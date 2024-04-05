<?php

namespace Telepath\ComplimentBot\Telepath;

use Telepath\ComplimentBot\Models\Compliment;
use Telepath\Handlers\ChosenInlineResult;
use Telepath\Telegram\Update;

class Feedback
{

    #[ChosenInlineResult]
    public function collect(Update $update)
    {
        $id = $update->chosen_inline_result->result_id;

        Compliment::whereId($id)->increment('usage');
    }

}