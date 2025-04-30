<?php

namespace WHMCS\Module\Notification\DiscordAlertPro;

use WHMCS\Module\Contracts\NotificationModuleInterface;
use WHMCS\Module\Notification\DescriptionTrait;
use WHMCS\Notification\Contracts\NotificationInterface;
use WHMCS\Config\Setting;
use WHMCS\Exception;

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
                'Description' => 'The Discord Webhook URL that notifications should be sent to.',
            ],
            'companyName' => [
                'FriendlyName' => 'Sender Name',
                'Type' => 'text',
                'Description' => 'The name that appears in Discord messages.',
            ],
            'discordColor' => [
                'FriendlyName' => 'Default Message Color (HEX)',
                'Type' => 'text',
                'Description' => 'Example: ff0000 for red. Do not include the # symbol.',
            ],
            'discordGroupID' => [
                'FriendlyName' => 'Discord Role ID (Optional)',
                'Type' => 'text',
                'Description' => 'Role to ping. Example: 123456789012345678',
            ],
            'discordWebHookAvatar' => [
                'FriendlyName' => 'Webhook Avatar URL',
                'Type' => 'text',
                'Description' => 'Direct link to avatar image (optional).',
            ],
            'silentMode' => [
                'FriendlyName' => 'Silent Mode',
                'Type' => 'yesno',
                'Description' => 'Disable all Discord notifications if enabled.',
            ],
        ];
    }

    public function notificationSettings()
    {
        return [
            'message' => [
                'FriendlyName' => 'Custom Message',
                'Type' => 'text',
                'Description' => 'Optional custom message for this notification.',
            ],
            'webhookURL' => [
                'FriendlyName' => 'Custom Webhook URL',
                'Type' => 'text',
                'Description' => 'Override webhook for this notification.',
            ],
            'discordColor' => [
                'FriendlyName' => 'Custom Message Color (HEX)',
                'Type' => 'text',
                'Description' => 'Custom color override for this message.',
            ],
            'discordGroupID' => [
                'FriendlyName' => 'Custom Role ID',
                'Type' => 'text',
                'Description' => 'Override role ping for this message.',
            ],
        ];
    }

    public function getDynamicField($fieldName, $settings)
    {
        return [];
    }

    public function testConnection($settings): bool
    {
        if (!file_exists(__DIR__ . '/143.key') || trim(file_get_contents(__DIR__ . '/143.key')) !== '143') {
            throw new Exception("Unauthorized Module Modification Attempt Detected.");
        }

        if (empty($settings['webhookURL'])) {
            throw new Exception("Webhook URL is required.");
        }

        return true;
    }

    public function sendNotification(NotificationInterface $notification, $moduleSettings, $notificationSettings)
    {
        if (!file_exists(__DIR__ . '/143.key') || trim(file_get_contents(__DIR__ . '/143.key')) !== '143') {
            return;
        }

        if (!empty($moduleSettings['silentMode']) && $moduleSettings['silentMode'] === 'on') {
            return;
        }

        $eventParams = $notification->getEvent()->getParams();
        $ip = $eventParams['ip'] ?? '';
        $adminName = $eventParams['admin'] ?? 'a staff';

        $flag = '';
        if ($ip) {
            $geo = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);
            if (empty($geo['countryCode'])) {
                $geo = @json_decode(file_get_contents("https://ipwho.is/{$ip}"), true);
            }
            $country = $geo['country'] ?? 'Unknown';
            $cc = strtolower($geo['countryCode'] ?? 'un');
            foreach (str_split(strtoupper($cc)) as $char) {
                $flag .= mb_convert_encoding('&#' . (ord($char) + 127397) . ';', 'UTF-8', 'HTML-ENTITIES');
            }
            $countryDisplay = "{$flag} {$country}";
        } else {
            $countryDisplay = "N/A";
        }

        $status = 'Unknown';
        foreach ($notification->getAttributes() as $attribute) {
            if (strtolower($attribute->getLabel()) === 'status') {
                $status = $attribute->getValue();
            }
        }

        $emojiMap = [
            'Open' => '🟢',
            'Answered' => '🟡',
            'Closed' => '🔴',
            'Customer-Reply' => '🟠',
        ];
        $emoji = $emojiMap[$status] ?? '🔘';

        $lastReplyRaw = $eventParams['lastreply'] ?? '';
        $lastReplyAgo = 'Unknown';
        if ($lastReplyRaw) {
            $lastTime = strtotime($lastReplyRaw);
            $nowTime = time();
            $diff = $nowTime - $lastTime;

            if ($diff < 60) {
                $lastReplyAgo = "{$diff} sec ago";
            } elseif ($diff < 3600) {
                $lastReplyAgo = round($diff / 60) . " min ago";
            } elseif ($diff < 86400) {
                $lastReplyAgo = round($diff / 3600) . " hr ago";
            } else {
                $lastReplyAgo = round($diff / 86400) . " days ago";
            }
        }

        $title = $notification->getTitle();
        $description = $notificationSettings["message"] ?: $notification->getMessage();
        $url = $notification->getUrl();

        $color = $notificationSettings["discordColor"] ??
                 $moduleSettings["discordColor"] ??
                 "7588619";
        $color = hexdec(ltrim($color, '#'));

        $group1 = $moduleSettings["discordGroupID"] ?? '';
        $group2 = $notificationSettings["discordGroupID"] ?? '';
        $mention = ($group1 ? "<@&{$group1}>" : '') . ($group2 ? "<@&{$group2}>" : '');

        $embed = (new Embed())
            ->title("🧑‍💻 {$title}")
            ->url($url)
            ->description("Responded by: {$adminName}")
            ->timestamp(date(\DateTime::ISO8601))
            ->color($color)
            ->footer("🛠 Developed by Kamrul");

        foreach ($notification->getAttributes() as $attribute) {
            $value = $attribute->getValue();
            if ($attribute->getUrl()) {
                $value = "[" . $value . "](" . $attribute->getUrl() . ")";
            }
            $embed->addField((new Field())
                ->name($attribute->getLabel())
                ->value($value));
        }

        $embed->addField((new Field())->name("Client Country")->value($countryDisplay));
        $embed->addField((new Field())->name("Client IP")->value($ip ?: 'N/A'));
        $embed->addField((new Field())->name("Status")->value("{$emoji} {$status}"));
        $embed->addField((new Field())->name("Last Reply")->value($lastReplyAgo));
        $embed->addField((new Field())->name("Date & Time")->value(date("Y-m-d | h:i A (T)")));

        $msg = (new Message())
            ->content($mention)
            ->username($moduleSettings["companyName"])
            ->avatarUrl($moduleSettings["discordWebHookAvatar"])
            ->embed($embed);

        $this->call($moduleSettings, $notificationSettings["webhookURL"] ?? $moduleSettings["webhookURL"], $msg->toArray());
    }

    protected function call(array $settings, $url, array $postdata = array(), $throwOnError = true)
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
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $decoded = json_decode($response, true);
        curl_close($ch);

        if ($code != 204 && $throwOnError) {
            logModuleCall('discord_alert_pro', 'Send Failed', $postdata, $response, $decoded);
            throw new Exception("Discord send failed: {$response}");
        }

        logModuleCall('discord_alert_pro', 'Send OK', $postdata, $response, $decoded);
        return $decoded;
    }
}
