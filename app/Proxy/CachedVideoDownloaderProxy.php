<?php

namespace App\Proxy;

class CachedVideoDownloaderProxy implements VideoDownloaderInterface {
    private VideoDownloaderInterface $realDownloader;

    private $cache = [];

    public function __construct(VideoDownloaderInterface $downloader) {
        $this->realDownloader = $downloader;
    }

    public function downloadVideo(string $videoId) {
        if (!isset($this->cache[$videoId])) {
            echo "⚠️ Cache miss. Passing request to RealDownloader...\n";
            $this->cache[$videoId] = $this->realDownloader->downloadVideo($videoId);
        } else {
            echo "✅ Serving from cache directly (No API call made): $videoId\n";
        }

        return $this->cache[$videoId];
    }
}
