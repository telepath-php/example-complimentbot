<?php

namespace Telepath\ComplimentBot\Telegram;

use Telepath\Handlers\Message\Command;
use Telepath\Telegram\Update;
use Telepath\TelegramBot;

class Start
{

    public function __construct(
        protected TelegramBot $bot
    ) {}

    #[Command('start')]
    public function start(Update $update)
    {
        $this->bot->sendMessage(
            chat_id: $update->chat()->id,
            text: 'Hello!'
        );
    }

}
