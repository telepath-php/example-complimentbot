<?php

namespace Telepath\ComplimentBot\Telepath;

use Telepath\ComplimentBot\Models\Compliment;
use Telepath\Conversations\Conversation;
use Telepath\Handlers\Message\Command;
use Telepath\Telegram\Update;

class ManageCompliments extends Conversation
{

    #[Command('add')]
    public function add(Update $update)
    {
        $text = $update->message->text();
        $author = $update->user()->id;

        if ($text === null) {
            $this->bot->sendMessage(
                chat_id: $update->message->chat->id,
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
            chat_id: $update->message->chat->id,
            text: 'Your compliment was added to our collection.'
        );

        $this->end();
    }

}