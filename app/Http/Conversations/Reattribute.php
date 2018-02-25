<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Contracts\Steps;
use Illuminate\Support\Facades\Auth;

class Reattribute extends Conversation implements Steps
{
    protected $question = 'Step 2 - Reattribute: Realize that the intensity and intrusiveness of the thought or urge is CAUSED BY OCD; it is probably related to a biochemical imbalance in the brain.';
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

            \Log::info("Step Reattribute with id: ".Auth::id());

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
        $this->askQuestion();
    }
}