<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    // return Socialite::driver('github')->redirect();
    return Socialite::driver('spotify')
        ->scopes([
            'user-read-playback-state',
            'user-modify-playback-state',
            'user-read-currently-playing',
            'playlist-read-private',
            'playlist-modify-public',
        ])
        ->redirect();
});

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


// SocialiteProviders\Manager\OAuth2\User {#410 ▼ // routes/socialite.php:23
//     +id: "al_personal"
//     +nickname: null
//     +name: "Al"
//     +email: null
//     +avatar: null
//     +user: array:8 [▼
//       "display_name" => "Al"
//       "external_urls" => array:1 [▶]
//       "followers" => array:2 [▶]
//       "href" => "https://api.spotify.com/v1/users/al_personal"
//       "id" => "al_personal"
//       "images" => []
//       "type" => "user"
//       "uri" => "spotify:user:al_personal"
//     ]
//     +token: "BQCu-Eb-FYSZpQUBEs_QeNPjWVr-sAFp-nyYqsGd5i6p9qM4-EN-mTYI0BK7lLuJ8-akAoqmBiJQjlGxvauG2sI838UJfDxl0A-WbdFXKjuB-9Wci9au0PQprzUSI6lYzDu2pxgZlqp6qJwKRB2HBzM8foYD1iMjWIKImankP8_hA4iLUGP40cTr_UmP4aMkyBP5gsf6Mg_gId7xKgCGJvwTymbCfHFwPyqt ◀"
//     +refreshToken: "AQCr0OMkBi9B7G_QaOB2T_MDELpB6rnDwkGXvoApbaJ6TKlN1J5t6ko-ksWWSM_AQJzZfwFgmNS1BydPH983m3UReaKD8HpHW0D9NtDUUW_ub0jxlxygHo-o9z_2q1k4DR4"
//     +expiresIn: 3600
//     +approvedScopes: null
//     +accessTokenResponseBody: array:5 [▶]
//     +"profileUrl": "https://api.spotify.com/v1/users/al_personal"
//   }
  