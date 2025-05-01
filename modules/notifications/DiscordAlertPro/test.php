<?php

use WHMCS\Module\Notification\DiscordAlertPro\Embed;
use WHMCS\Module\Notification\DiscordAlertPro\Field;
use WHMCS\Module\Notification\DiscordAlertPro\Message;

require_once __DIR__ . '/lib/Embed.php';
require_once __DIR__ . '/lib/Field.php';
require_once __DIR__ . '/lib/Message.php';

session_start();
if (!isset($_SESSION['adminid'])) {
    http_response_code(403);
    exit('Unauthorized');
}

$webhook = $_POST['webhook'] ?? '';
$sender = $_POST['sender'] ?? 'Test Bot';
$avatar = $_POST['avatar'] ?? '';
$color = hexdec($_POST['color'] ?? '3498db');

$embed = (new Embed())
    ->title('Test Notification')
    ->description('This is a test message sent from Discord Alert Pro.')
    ->timestamp(date(\DateTime::ISO8601))
    ->color($color)
    ->footer('Discord Alert Pro • v1.1.0');

$embed->addField((new Field())->name('Sent By')->value($sender));
$embed->addField((new Field())->name('Time')->value(date('Y-m-d h:i A')));

$message = (new Message())
    ->content('Manual Test Triggered')
    ->username($sender)
    ->avatarUrl($avatar)
    ->embed($embed);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $webhook);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message->toArray()));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo ($code == 204) ? 'Success' : 'Failed';
