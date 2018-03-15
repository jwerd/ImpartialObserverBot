<?php

namespace App\Http\Conversations;

use App\Journal;
use App\User;
use BotMan\BotMan\Messages\Incoming\Answer;
use App\Contracts\Steps;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class FinishConversation extends BaseConversation implements Steps
{
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
            ]);
        return $this->ask($question, function (Answer $answer) {

            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() === 'finished') {
                    \Log::info('Completed', $this->bot->userStorage()->all());

                    $provider = $this->bot->getDriver()->getName();

                    $journal = Journal::create([
                        'subject' => $this->bot->userStorage()->get('addictive_thought'),
                        'body'    => $this->bot->userStorage()->get('revalue_text'),
                        'user_id' => User::getUserByProvider($provider, $this->bot->getUser()->getId())
                    ]);


                    \Log::info($journal);

                    // Remove the user storage for this instance since it's persisted to DB.
                    $this->bot->userStorage()->delete();

                    $this->say('All set.  It takes courage to do what you just did.  When you are ready to start again, type /start');
                }
            } else {
                if (!empty($answer->getText())) {
                    $text = $this->bot->userStorage()->get('revalue_text');

                    $text .= PHP_EOL.$answer->getText();

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
