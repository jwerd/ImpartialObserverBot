<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Contracts\Steps;

class Relabel extends Conversation implements Steps
{
    protected $question = 'Step 1 - Relabel: Recognize that the intrusive obsessive thoughts and urges are the RESULT OF OCD/ADDICTION.  Type \'more\' to get more detail on this step';
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
        $this->ask('The goal of Step 1 is to learn to Relabel intrusive thoughts and urges in your own mind as obsessions and compulsions~and to do so assertively. Start calling them that; use the labels obsession and compulsion. For example, train yourself to say, "I don\'t think or feel that my hands are dirty. I\'m having an obsession that my hands are dirty." Or, "I don\'t feel that I have the need to wash my hands. I\'m having a compulsive urge to perform the compulsion of washing my hands." (The technique is the same for other obsessions and compulsions, including compulsive checking of doors or appliances and needless counting.) You must learn to recognize the intrusive, obsessive thoughts and urges as OCD/ADDICTION.', function(Answer $answer) {

            $this->answer = $answer->getText();

            $this->bot->startConversation(new Reattribute());
        });
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
