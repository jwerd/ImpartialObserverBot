<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class StartConversation extends Conversation
{
    protected $steps = [
        'Relabel'     => Steps\Relabel::class,
        'Reattribute' => Steps\Reattribute::class,
        'Refocus'     => Steps\Refocus::class,
        'Revalue'     => Steps\Revalue::class,
    ];
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        collect($this->steps)->map(function ($step) {
            (new $step)->run();
        });
    }
}
