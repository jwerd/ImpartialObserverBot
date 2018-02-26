<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Contracts\Steps;

class Relabel extends Conversation implements Steps
{
    protected $question = 'Step 1 - Re-label';
    protected $answer_step1;

    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $this->ask($this->question, function(Answer $answer) {
            if($answer->getText() === "more") {
                $this->askExtended();
            }

            $this->answer_step1 = $answer->getText();

            $this->bot->startConversation(new Reattribute());
        });
    }

    public function askExtended()
    {
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askQuestion();
    }
}
