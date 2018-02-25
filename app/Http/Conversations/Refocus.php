<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Contracts\Steps;

class Refocus extends Conversation implements Steps
{
    protected $question = 'Step 2 - Work around the OCD/ADDICTION thoughts by focusing your attention on something else, at least for a few minutes: DO ANOTHER BEHAVIOR.';
    protected $answer_step2;

    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $this->ask($this->question, function(Answer $answer) {
            if($answer->getText() === "more") {
                $this->askExtended();
            }

            $this->answer_step2 = $answer->getText();

            $this->bot->startConversation(new Refocus());
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
        $this->bot->startConversation(new StartConversation());
    }
}
