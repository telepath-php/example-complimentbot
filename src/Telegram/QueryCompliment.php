<?php

namespace Telepath\ComplimentBot\Telegram;

use Telepath\ComplimentBot\Models\Compliment;
use Telepath\Handlers\InlineQuery;
use Telepath\Telegram\InlineQueryResultArticle;
use Telepath\Telegram\InputTextMessageContent;
use Telepath\Telegram\Update;
use Telepath\TelegramBot;

class QueryCompliment
{

    public function __construct(
        protected TelegramBot $bot
    ) {}

    const RESULTS_PER_PAGE = 50;

    #[InlineQuery]
    public function query(Update $update)
    {
        $search = $update->inline_query->query;
        $offset = (int) $update->inline_query->offset;

        $query = Compliment::query();
        if ($search !== '') {
            $query->search($search);
        }
        $query->limit(self::RESULTS_PER_PAGE)
            ->offset($offset);
        $compliments = $query->get();

        $results = [];
        foreach ($compliments as $compliment) {
            $results[] = InlineQueryResultArticle::make(
                id: $compliment->id,
                title: $compliment->compliment,
                input_message_content: InputTextMessageContent::make($compliment->compliment),
            );
        }

        $this->bot->answerInlineQuery(
            inline_query_id: $update->inline_query->id,
            cache_time: 0,
            next_offset: $offset + self::RESULTS_PER_PAGE,
            results: $results,
        );
    }

}