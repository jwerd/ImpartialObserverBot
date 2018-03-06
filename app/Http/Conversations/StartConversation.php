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
        $this->ask("Greetings, I'm the Impartial Observer.  
        
Describe your current addictive thought/urge you are experiencing and wish to manage with the four steps.

My current urge or thought to... ", function(Answer $answer) {

            $this->bot->userStorage()->save([
                'addictive_thought' => $answer->getText()
            ]);

            $this->bot->startConversation(new Relabel());
        });
    }
}
