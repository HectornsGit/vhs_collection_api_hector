<?php
#Basic controller to check if the application is live.
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        try {

            $name = $request->query->get("name", "");
            $page = $request->query->get("page", "1");

            $httpClient;

            $data = fetchMoviesFromMovieDbByName($name, $page, $httpClient);

            return new JsonResponse($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
