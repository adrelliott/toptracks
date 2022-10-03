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
            '1' => $this->spotify->api->getPlaylists(),
            '2' => $this->spotify->api->getMe(),
            '3' => $this->spotify->api->getCurrentTrack(),
        };
    }

    


}
