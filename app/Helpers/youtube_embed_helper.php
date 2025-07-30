<?php
function youtube_embed($url)
{
    // Temukan ID video dari URL YouTube
    $videoId = '';
    $parsedUrl = parse_url($url);
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $query);
        if (isset($query['v'])) {
            $videoId = $query['v'];
        }
    }

    // Jika ID video ditemukan, susun URL embed
    if (!empty($videoId)) {
        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
        return $embedUrl;
    } else {
        // Jika ID video tidak ditemukan, kembalikan URL asli
        return $url;
    }
}

function get_youtube_video_id($youtubeUrl)
{
    // Mengambil query string dari URL
    $queryString = parse_url($youtubeUrl, PHP_URL_QUERY);

    // Mengubah query string ke dalam bentuk array
    parse_str($queryString, $queryParameters);

    // Mengambil nilai dari parameter 'v' (ID video)
    $videoId = isset($queryParameters['v']) ? $queryParameters['v'] : null;

    return $videoId;
}
