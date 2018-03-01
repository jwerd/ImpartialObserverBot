<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;

class StartConversation extends BaseConversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->ask("Greetings, I'm the Impartial Observer.   What is your addictive thought/urge currently?
        
In one word describe it.   Examples: Shopping addiction, porn addiction, sex addiction, impulsive eating addiction, etc.

I want to manage my ______ addiction", function(Answer $answer) {

            $this->bot->userStorage()->save([
                'addictive_thought' => $answer->getText()
            ]);

            $this->bot->startConversation(new Relabel());
        });
    }
}
