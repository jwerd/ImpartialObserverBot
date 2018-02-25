<?php

namespace App\Http\Controllers;

use App\Http\Conversations\StartConversation;
use BotMan\BotMan\BotMan;
use App\User;
use Illuminate\Support\Facades\Auth;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $provider = $bot->getDriver()->getName();
        if($provider !== "Web") {
            // Store our user
            $user = User::firstOrCreate([
                'provider'    => $provider,
                'provider_id' => $bot->getUser()->getId()
            ]);

            // Login
            Auth::loginUsingId($user->id);

            \Log::info("Logging in user with id: ".Auth::id());

            $bot->startConversation(new StartConversation());
        }
    }
}
