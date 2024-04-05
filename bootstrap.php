<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Telepath\Bot;
use Telepath\Facades\BotBuilder;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$capsule = new Capsule;

$capsule->addConnection([
    'driver'   => $_ENV['DB_CONNECTION'],
    'host'     => $_ENV['DB_HOST'],
    'port'     => $_ENV['DB_PORT'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset'  => 'utf8mb4',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

function bot(): Bot
{
    return BotBuilder::token($_ENV['TELEGRAM_API_TOKEN'])
        ->handlerPath(__DIR__ . '/src/Telepath')
        ->apiServerUrl($_ENV['TELEGRAM_API_URL'] ?: null)
        ->httpProxy($_ENV['TELEPATH_PROXY'] ?: null)
        ->useCache(new FilesystemAdapter(
            directory: __DIR__ . '/storage/cache/'
        ))->build();
}