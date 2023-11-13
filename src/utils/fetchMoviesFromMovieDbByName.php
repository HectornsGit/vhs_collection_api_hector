<?php

use Symfony\Contracts\HttpClient\HttpClientInterface;

function fetchMoviesFromMovieDbByName(string $name = "", string $page, HttpClientInterface  $httpClient)
{
    $apiToken = $_ENV["API_TOKEN"];
    $url = "https://api.themoviedb.org/3/search/movie?query=" . $name . "&include_adult=false&language=en-US&page=" . $page;
    var_dump($url);
    try {
        #If the query is empty redirects to a list of popular films.
        if (empty($name) === true) $url = "https://api.themoviedb.org/3/movie/popular";

        $response = $httpClient->request("GET", $url, [
            "headers" => [
                "Authorization" => "Bearer " . $apiToken,
                "accept" => "application/json",
            ],
        ]);

        $data = json_decode($response->getContent());
        return $data;
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
