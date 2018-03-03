<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use App\Contracts\Steps;

class Revalue extends BaseConversation implements Steps
{
    protected $question = 'Step 4 - Re-value';

    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $question = $this->stepQuestion('Step 4: Re-value - This step should really be called De-value. Its purpose is to help you drive into your own thick skull just what has been the real impact of the addictive urge in your life: disaster. You know this already, and that is why you are engaged in these four steps. It’s because of the negative impact that you’ve taken yourself by the scruff of the neck and delayed acting on the impulse while you’ve re-labelled and re-attributed it and while you have re-focused on some healthier activity. In this Re-value step you will remind yourself why you’ve gone to all this trouble. The more clearly you see how things are, the more liberated you will be.
        
        ...');

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() === 'reset') {
                    $this->bot->startConversation(new StartConversation());
                }
                if ($answer->getValue() === 'next') {
                    $this->bot->startConversation(new Revalue());
                }
            }
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
