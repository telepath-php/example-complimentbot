<?php

namespace Telepath\ComplimentBot\Telepath;

use Telepath\Bot;
use Telepath\Handlers\Message\Command;
use Telepath\Telegram\Update;

class Start
{

    #[Command('start')]
    public function start(Bot $bot, Update $update)
    {
        $bot->sendMessage(
            chat_id: $update->message->chat->id,
            text: 'Hello!'
        );
    }

}
