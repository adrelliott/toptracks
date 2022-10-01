<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    // return Socialite::driver('github')->redirect();
    return Socialite::driver('spotify')->redirect();
});
 
// Route::get('/auth/callback', function () {
//     $user = Socialite::driver('github')->user();
 
//     // $user->token
// });

Route::get('/auth/callback/spotify', function () {
    $spotifyUser = Socialite::driver('spotify')->user();
    $user = Auth::user();

    $user->spotify_id = $spotifyUser->id;
    $user->spotify_avatar = $spotifyUser->avatar;
    $user->spotify_profile_url = $spotifyUser->profileUrl;
    $user->spotify_token = $spotifyUser->token;
    $user->spotify_refresh_token = $spotifyUser->refreshToken;
    $user->save();
 
    return redirect('/dashboard');
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

