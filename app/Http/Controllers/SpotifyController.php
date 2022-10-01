<?php

namespace App\Http\Controllers;

use App\Services\SpotifyApiService;


class SpotifyController extends Controller
{
    private $spotify;

    public function __invoke($command = null): mixed
    {
        $this->spotify = new SpotifyApiService;
        
        return match ($command) {
            '1' => $this->getPlaylists(),
            '2' => $this->getMe(),
        };
    }

    public function getPlaylists() 
    {
        try {
            $playlists = $this->spotify->api->getMyPlaylists();
            dump($playlists);
        }
        catch (\Exception $e) {
            dump($e);
        }
    }

    public function getMe()
    {
        try {
            return $this->spotify->api->me();
        } catch (\Exception $e) {
            dump($e);
        }
    }

}
