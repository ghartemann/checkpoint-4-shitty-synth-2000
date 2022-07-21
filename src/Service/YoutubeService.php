<?php

namespace App\Service;

class YoutubeService
{
    public function trimYoutube($track): string
    {
        $youtube = $track->getYoutube();
        $youtube = str_replace('https://www.youtube.com/watch?v=', '', $youtube);
        $youtube = str_replace('http://www.youtube.com/watch?v=', '', $youtube);
        $youtube = str_replace('www.youtube.com/watch?v=', '', $youtube);
        $youtube = str_replace('youtube.com/watch?v=', '', $youtube);
        $youtube = str_replace('https://youtu.be/', '', $youtube);
        
        return $youtube;
    }
}
