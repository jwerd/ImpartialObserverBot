<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class StartConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->ask("Greetings, I'm the Impartial Observer.   What is your addictive thought currently?
        
In one word describe it.  

My addiction is...", function(Answer $answer) {

            $this->bot->userStorage()->save([
                'addictive_thought' => $answer->getText()
            ]);

            \Log::info($this->bot->userStorage()->get('addictive_thought'));

            $this->bot->startConversation(new Relabel());
        });
    }
}
