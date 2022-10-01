<?php

namespace App\Services;

class SpotifyApiService {

    private string $accessToken;
    public $api;

    public function __construct()
    {
        $this->setAccessToken();
        $this->setApi();
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
        $session->refreshAccessToken($user->spotify_refresh_token);

        // Save token in session & update spotify_refresh_token
        $this->accessToken = $session->getAccessToken();
        session(['spotify_access_token' => $this->accessToken]);
        $user->spotify_refresh_token = $session->getRefreshToken();
        $user->save();
    }

}
