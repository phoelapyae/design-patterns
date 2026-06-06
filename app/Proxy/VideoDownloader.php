<?php

namespace App\Proxy;

class VideoDownloader implements VideoDownloaderInterface {
    public function downloadVideo(string $videoId) {
        echo "🌐 Downloading video strictly from YouTube API: $videoId...\n";

        return "Video_File_Data_For_$videoId";
    }
}
