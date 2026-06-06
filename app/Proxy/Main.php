<?php

namespace App\Proxy;

class Main {
    public static function run() {
        $realDownloader = new VideoDownloader();
        $cachedDownloader = new CachedVideoDownloaderProxy($realDownloader);

        // First download (cache miss)
        $cachedDownloader->downloadVideo("abc123");

        // Second download (cache hit)
        $cachedDownloader->downloadVideo("abc123");

        // Downloading a different video (cache miss)
        $cachedDownloader->downloadVideo("def456");
    }
}
