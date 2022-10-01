<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});
 
Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
 
    // $user->token
});

Route::get('/auth/callback/github', function () {
    $githubUser = Socialite::driver('github')->user();

    $user = User::updateOrCreate(
        ['email' => $githubUser->email],
        [
            'name' => $githubUser->name,
            'github_id' => $githubUser->id,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]
    );
 
    Auth::login($user, true); 
    return redirect('/dashboard');
});

// remember_token => null
//     created_at => 2022-10-01 10:39:11
//     updated_at => 2022-10-01 11:04:45
//     github_id => 2983813
//     github_token => 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
//     github_refresh_token => null
