<?php

namespace App\Http\Conversations;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
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
        $question = Question::create("Hi, I'm the Impartial Observer.  I'm here to collect your thoughts during the 4 steps.  Make your selection:")
            ->fallback('Unable to proceed')
            ->callbackId('step')
            ->addButtons([
                Button::create('Let\'s go!')->value('start'),
                Button::create('What is this')->value('what'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'start') {
                    $this->bot->startConversation(new Relabel());
                } else {
                    $this->say('This is something based on the work of Dr. Jeffrey Schwartz\'s.  More here soon.');
                }
            }
        });
    }
}
