<?php

namespace App\Template\Example2;

class FacebookPost extends SocialMediaPost {
    protected function formatContent() { echo "Formatting text for Facebook...\n"; }
}
