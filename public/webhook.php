<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Telepath\TelegramBot;

require __DIR__ . '/../bootstrap.php';

$apiUrl = $_ENV['TELEGRAM_API_SERVER'] ?? TelegramBot::DEFAULT_API_SERVER_URL;
$bot = new TelegramBot($_ENV['TELEGRAM_BOT_TOKEN'], $apiUrl);

if ($_ENV['TELEPATH_PROXY']) {
    $bot->enableProxy($_ENV['TELEPATH_PROXY']);
}

$bot->discoverPsr4(__DIR__ . '/../src/Telegram');
$bot->enableCaching(new FilesystemAdapter(
    directory: __DIR__ . '/../storage/cache/'
));

$bot->handleWebhook();