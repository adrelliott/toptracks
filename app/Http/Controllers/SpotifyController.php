<?php

namespace App\Http\Controllers;

use App\Services\SpotifyApiService;
use Exception;

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

    private function handleException(\Exception $e)
    {
        // is it a connection issue?

        // is it a timeput issue?
        dump($e);
    }

}
