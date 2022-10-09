<?php

namespace Telepath\ComplimentBot\Telegram;

use Telepath\ComplimentBot\Models\Compliment;
use Telepath\Conversations\Conversation;
use Telepath\Handlers\Message\Command;
use Telepath\Telegram\Message;
use Telepath\Telegram\Update;
use Telepath\TelegramBot;

class ManageCompliments extends Conversation
{

    public function __construct(
        protected TelegramBot $bot
    ) {
        parent::__construct($bot);
    }

    protected function getTextWithoutCommand(Message $message): ?string
    {
        $text = $message->text;
        $offset = 0;

        foreach ($message->entities as $entity) {
            if ($entity->type === 'bot_command') {
                $text = substr_replace($text, '', $offset + $entity->offset, $entity->length);
                $offset += $entity->length;
            }
        }

        return trim($text) ?: null;
    }

    #[Command('add')]
    public function add(Update $update)
    {
        $text = $this->getTextWithoutCommand($update->message);
        $author = $update->user()->id;

        if ($text === null) {
            $this->bot->sendMessage(
                chat_id: $update->chat()->id,
                text: 'Which compliment do you want to add?'
            );
            $this->next('add');
            return;
        }

        Compliment::create([
            'compliment' => $text,
            'created_by' => $author,
        ]);

        $this->bot->sendMessage(
            chat_id: $update->chat()->id,
            text: 'Your compliment was added to our collection.'
        );

        $this->end();
    }

}