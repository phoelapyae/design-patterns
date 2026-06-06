<?php

namespace App\Proxy;

interface VideoDownloaderInterface {
    public function downloadVideo(string $videoId);
}
