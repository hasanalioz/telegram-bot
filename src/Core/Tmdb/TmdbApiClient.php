<?php

namespace hasanalioz\Core\Tmdb;

class TmdbApiClient
{
    private $baseURL = 'https://api.themoviedb.org/3/';

    public function __construct()
    {
        TmdbConfig::setToken('05d2dab8bddb343ebbf75fc711bfd755');
    }

    public function popularMovies()
    {
        $api_url = $this->baseURL . 'movie/popular';
        $api_url .= '?api_key=' . TmdbConfig::getToken();

        $response = file_get_contents($api_url);

        if ($response === false) {
            return 'Sunucudan geçerli bir yanıt alınamadı.';
        }

        $movies = json_decode($response, true);

        if ($movies === null) {
            return 'Sunucudan geçerli bir JSON yanıtı alınamadı.';
        }

        $result = '';

        foreach ($movies['results'] as $movie) {
            $result .= $movie['title'] . '<br>';
        }

        return ($result !== '') ? $result : 'Bir Şey Bulunamadı';
    }

    public function deneme()
    {
        return TmdbConfig::getToken();
    }

    public function topRatedMovies()
    {
        $api_url = $this->baseURL . 'movie/top_rated';
        $api_url .= '?api_key=' . TmdbConfig::getToken();

        $response = file_get_contents($api_url);

        if ($response === false) {
            return 'Sunucudan geçerli bir yanıt alınamadı.';
        }

        $movies = json_decode($response, true);

        if ($movies === null) {
            return 'Sunucudan geçerli bir JSON yanıtı alınamadı.';
        }

        $result = '';

        foreach ($movies['results'] as $movie) {
            $result .= $movie['title'] . '<br>';
        }

        return ($result !== '') ? $result : 'Bir Şey Bulunamadı';
    }


    public function searchMovies($movie)
    {
        $params = [
            'api_key' => TmdbConfig::getToken(),
            'query' => $movie,
        ];

        $api_url = $this->baseURL . 'search/movie' . '?' . http_build_query($params);
        $ch = curl_init($api_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return 'Hata: ' . curl_error($ch);
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if ($data === null) {
            return 'Sunucudan geçerli bir JSON yanıtı alınamadı.';
        }

        $result = '';

        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $resultItem) {
                $result .= $resultItem['title'] . PHP_EOL;
            }
        } else {
            return 'Sonuç bulunamadı.';
        }

        return ($result !== '') ? $result : 'Bir Şey Bulunamadı';
    }
}