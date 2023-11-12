<?php
#Basic controller to check if the application is live.
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieDbSearchController extends AbstractController
{
    #[Route(path: "/moviedbsearch", name: "moviedbsearch", methods: ["GET"])]
    public function getFilmDataFromMovieDB(HttpClientInterface $httpClient, Request $request): Response
    {
        $apiToken = $_ENV['API_TOKEN'];
        $query = $request->query->get("query", "");
        $page = $request->query->get("page", "1");
        $url = "https://api.themoviedb.org/3/search/movie?query=" . $query . "&include_adult=false&language=en-US&page=" . $page;

        try {
            #If the query is empty redirects to a list of popular films.
            if (empty($query) === true) $url = "https://api.themoviedb.org/3/movie/popular";

            $response = $httpClient->request("GET", $url, [
                "headers" => [
                    "Authorization" => "Bearer " . $apiToken,
                    "accept" => "application/json",
                ],
            ]);

            $data = json_decode($response->getContent());

            return new JsonResponse($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
