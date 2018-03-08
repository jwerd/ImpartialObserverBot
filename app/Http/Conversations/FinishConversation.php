<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use App\Contracts\Steps;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class FinishConversation extends BaseConversation implements Steps
{
    protected $question = 'Step 4 - Re-value';

    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $question = Question::create('I\'m Listening.  Keep going.  Press "I\'m Finished" when you are done.')
            ->fallback('Unable to proceed')
            ->callbackId('step')
            ->addButtons([
                Button::create('I\'m Finished')->value('finished'),
                Button::create('Start Over')->value('reset'),
            ]);
        return $this->ask($question, function (Answer $answer) {

            if ($answer->isInteractiveMessageReply()) {

                if($answer->getValue() === 'finished') {
                    \Log::info('Completed', $this->bot->userStorage()->all());
                    $this->bot->startConversation(new StartConversation());
                }

                if($answer->getValue() === 'reset') {
                    $this->bot->startConversation(new StartConversation());
                }
            } else {
                if (!empty($answer->getText())) {
                    $text = $this->bot->userStorage()->get('revalue_text');

                    // Append extra text
                    if (!empty($text)) {
                        $text .= $answer->getText();
                    }

                    $this->bot->userStorage()->save([
                        'revalue_text' => $text
                    ]);

                    $this->bot->startConversation(new FinishConversation());
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
