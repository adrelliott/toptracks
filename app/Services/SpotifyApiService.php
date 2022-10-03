<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class SpotifyApiService {

    private string $accessToken;
    public $api;

    public function __construct()
    {
        $this->setAccessToken();
        $this->setApi();
    }

    public function handleException($e)
    {
        // check if the exception is of type \SpotifyWebAPI\SpotifyWebAPIException
        // Token has expired
        if ($e->hasExpiredToken()) {
            $this->refreshToken();

            return 'try again';
            // flash data and redirect back
        }

        dump($e);
    }

    public function getPlaylists() 
    {
        try {
            return $this->spotify->api->getMyPlaylists();
        }
        catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    public function getMe()
    {
        try {
            return $this->spotify->api->me();
        }
        catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    public function getCurrentTrack()
    {
        try {
            return dump($this->spotify->api->getMyCurrentTrack());
        }
        catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    private function setApi()
    {
        $this->api = new \SpotifyWebAPI\SpotifyWebAPI();
        $this->api->setAccessToken($this->accessToken);
    }

    private function setAccessToken(): void
    {
        $this->accessToken = session('spotify_access_token', false);

        if (! $this->accessToken) {
            $this->refreshToken();
        }
    }

    private function refreshToken(): void 
    {
        $user = auth()->user();

        // get new token
        $session = new \SpotifyWebAPI\Session(
            config('spotify.auth.client_id'),
            config('spotify.auth.client_secret')
        );
        $decryptedToken = $this->decryptToken($user->spotify_refresh_token);
        $session->refreshAccessToken($decryptedToken);

        // Save token in session...
        $this->accessToken = $session->getAccessToken();
        session(['spotify_access_token' => $this->accessToken]);
        
        // ...& update spotify_refresh_token
        $user->spotify_refresh_token = $session->getRefreshToken();
        $user->save();
    }

    private function decryptToken(string $encrypted)
    {
        try {
            return Crypt::decryptString($encrypted);
        } catch (DecryptException $e) {
            dd('decrypt failed');
            abort(500); //perhpas get them to reconnect?
        }
        
    }

}
