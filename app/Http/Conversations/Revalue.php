<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class Revalue extends Conversation
{
    protected $name;

    /**
     * @return mixed
     */
    public function askForName()
    {
        $this->ask('What is your name?', function(Answer $answer) {

            $this->name = $answer->getText();

            $this->say('Nice to meet you '.$this->name);
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askForName();
    }
}
