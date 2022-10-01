<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class SpotifyConnectController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('spotify')
            ->scopes([
                'user-read-playback-state',
                'user-modify-playback-state',
                'user-read-currently-playing',
                'playlist-read-private',
                'playlist-modify-public',
            ])
            ->redirect();
    }

    public function callback()
    {
        $spotifyUser = Socialite::driver('spotify')->user();
        $user = auth()->user();

        $user->spotify_id = $spotifyUser->id;
        $user->spotify_avatar = $spotifyUser->avatar;
        $user->spotify_profile_url = $spotifyUser->profileUrl;
        $user->spotify_refresh_token = $spotifyUser->refreshToken;
        $user->save();
    
        return redirect('/dashboard');
    }
}
