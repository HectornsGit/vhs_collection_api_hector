<?php

use Symfony\Contracts\HttpClient\HttpClientInterface;

function fetchMovieFromMovieDbById(int $moviedb_id, HttpClientInterface $httpClient): array|string|stdClass
{

    $apiToken = $_ENV["API_TOKEN"];
    $url = "https://api.themoviedb.org/3/movie/" . $moviedb_id;

    try {

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
