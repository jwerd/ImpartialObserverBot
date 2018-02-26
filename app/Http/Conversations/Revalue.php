<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Contracts\Steps;

class Revalue extends Conversation implements Steps
{
    protected $question = 'Step 4 - Re-value';

    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $this->ask($this->question, function(Answer $answer) {
            if($answer->getText() === "more") {
                $this->askExtended();
            }

            $this->bot->userStorage()->save([
                'step4' => $answer->getText()
            ]);

            \Log::info($this->bot->userStorage()->all());

            $this->bot->startConversation(new StartConversation());
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
