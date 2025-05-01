<?php

use WHMCS\Module\Notification\DescriptionTrait;
use WHMCS\Module\Contracts\NotificationModuleInterface;
use WHMCS\Notification\Contracts\NotificationInterface;
use WHMCS\Exception;

require_once __DIR__ . '/lib/Embed.php';
require_once __DIR__ . '/lib/Field.php';
require_once __DIR__ . '/lib/Message.php';

class DiscordAlertPro implements NotificationModuleInterface
{
    use DescriptionTrait;

    public function __construct()
    {
        $this->setDisplayName('Discord Alert Pro')
            ->setLogoFileName('logo.png');
    }

    public function settings()
    {
        return [
            'webhookURL' => [
                'FriendlyName' => 'Discord Webhook URL',
                'Type' => 'text',
                'Description' => 'Main Discord webhook to send notifications.',
            ],
            'companyName' => [
                'FriendlyName' => 'Sender Name',
                'Type' => 'text',
                'Description' => 'Name shown as the sender in Discord.',
            ],
            'discordColor' => [
                'FriendlyName' => 'Embed Color (HEX)',
                'Type' => 'text',
                'Placeholder' => '3498db',
                'Description' => 'Color of the embed bar (exclude #)',
            ],
            'discordGroupID' => [
                'FriendlyName' => 'Discord Role ID (Optional)',
                'Type' => 'text',
                'Description' => 'Optional: Role ID to ping (mention).',
            ],
            'discordWebHookAvatar' => [
                'FriendlyName' => 'Avatar Image URL',
                'Type' => 'text',
                'Description' => 'Optional image URL for the webhook sender avatar.',
            ],
            'silentMode' => [
                'FriendlyName' => 'Silent Mode',
                'Type' => 'yesno',
                'Description' => 'Disable all Discord messages temporarily.',
                'Default' => 'off',
            ],
            'showFlag' => [
                'FriendlyName' => 'Show Country Flag',
                'Type' => 'yesno',
                'Description' => 'Display flag emoji based on IP country.',
                'Default' => 'on',
            ],
            'ipApi' => [
                'FriendlyName' => 'IP Location API',
                'Type' => 'dropdown',
                'Options' => [
                    'ip-api' => 'ip-api.com',
                    'ipwho' => 'ipwho.is',
                ],
                'Default' => 'ip-api',
            ],
            'addonVersion' => [
                'FriendlyName' => 'Addon Version',
                'Type' => 'text',
                'Default' => 'v1.1.0',
                'ReadOnly' => true,
            ],
        ];
    }

    public function testConnection($settings): bool
    {
        if (empty($settings['webhookURL'])) {
            throw new Exception("Webhook URL is required.");
        }
        return true;
    }

    public function notificationSettings()
    {
        return [
            'message' => [
                'FriendlyName' => 'Custom Message (Optional)',
                'Type' => 'text',
                'Description' => 'Optional override for notification message.',
            ],
        ];
    }

    public function getDynamicField($fieldName, $settings)
    {
        return [];
    }

    public function sendNotification(NotificationInterface $notification, $moduleSettings, $notificationSettings)
    {
        $lockPath = __DIR__ . '/143.key';
        if (!file_exists($lockPath) || trim(file_get_contents($lockPath)) !== '143') {
            return; // Developer Lock Active
        }

        if (isset($moduleSettings['silentMode']) && $moduleSettings['silentMode'] === 'on') {
            return;
        }

        $webhook = $notificationSettings['webhookURL'] ?: $moduleSettings['webhookURL'];
        $senderName = $moduleSettings['companyName'] ?: 'WHMCS Bot';
        $colorHex = $notificationSettings['discordColor'] ?: $moduleSettings['discordColor'] ?: '3498db';
        $color = hexdec($colorHex);
        $avatar = $moduleSettings['discordWebHookAvatar'] ?: '';
        $roleID = $notificationSettings['discordGroupID'] ?: $moduleSettings['discordGroupID'] ?: '';
        $flagEnabled = $moduleSettings['showFlag'] !== 'off';
        $ipApi = $moduleSettings['ipApi'] ?: 'ip-api';

        $clientIp = $_SERVER['REMOTE_ADDR'];
        $country = 'Unknown';
        $flag = '';

        if ($flagEnabled) {
            try {
                if ($ipApi === 'ipwho') {
                    $data = json_decode(file_get_contents("http://ipwho.is/{$clientIp}"), true);
                    $country = $data['country'] ?? 'Unknown';
                    $flag = $this->convertCountryCodeToEmoji($data['country_code'] ?? '');
                } else {
                    $data = json_decode(file_get_contents("http://ip-api.com/json/{$clientIp}"), true);
                    $country = $data['country'] ?? 'Unknown';
                    $flag = $this->convertCountryCodeToEmoji($data['countryCode'] ?? '');
                }
            } catch (\Exception $e) {
                $country = 'N/A';
                $flag = '';
            }
        }

        $msg = $notificationSettings['message'] ?: $notification->getMessage();
        $title = $notification->getTitle();
        $url = $notification->getUrl();

        $embed = (new \WHMCS\Module\Notification\DiscordAlertPro\Embed())
            ->title($title)
            ->url($url)
            ->description($msg)
            ->timestamp(date(\DateTime::ISO8601))
            ->color($color)
            ->footer("Discord Alert Pro • v1.1.0");

        foreach ($notification->getAttributes() as $attribute) {
            $value = $attribute->getValue();
            if ($attribute->getUrl()) {
                $value = "[" . $value . "](" . $attribute->getUrl() . ")";
            }
            $embed->addField((new \WHMCS\Module\Notification\DiscordAlertPro\Field())
                ->name($attribute->getLabel())
                ->value($value));
        }

        $embed->addField((new \WHMCS\Module\Notification\DiscordAlertPro\Field())->name('IP')->value($clientIp));
        $embed->addField((new \WHMCS\Module\Notification\DiscordAlertPro\Field())->name('Location')->value($flag . ' ' . $country));

        $content = $roleID ? "<@&{$roleID}>" : '';

        $message = (new \WHMCS\Module\Notification\DiscordAlertPro\Message())
            ->content($content)
            ->username($senderName)
            ->avatarUrl($avatar)
            ->embed($embed);

        $this->call($webhook, $message->toArray());
    }

    private function convertCountryCodeToEmoji($code)
    {
        $offset = 127397;
        $emoji = '';
        $code = strtoupper($code);
        for ($i = 0; $i < strlen($code); $i++) {
            $emoji .= mb_convert_encoding('&#' . (ord($code[$i]) + $offset) . ';', 'UTF-8', 'HTML-ENTITIES');
        }
        return $emoji;
    }

    protected function call($url, array $postdata = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_exec($ch);
        curl_close($ch);
    }
}
