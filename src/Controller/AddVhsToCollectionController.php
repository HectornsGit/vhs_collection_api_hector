<?php

namespace App\Controller;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Vhs;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AddVhsToCollectionController extends AbstractController
{
    #[Route('/collection/add', name: 'add_movie_to_collection', methods: ["POST"])]
    public function addVhsToCollection(Request $request, EntityManagerInterface $entityManager, HttpClientInterface $httpClient): Response
    {
        try {
            $requestData = json_decode($request->getContent())[0];

            $moviedbId = $requestData->moviedb_id;
            $collectionName = $requestData->collection;

            $movieInfo = fetchMovieFromMovieDbById($moviedbId, $httpClient);
            $originalTitle = $movieInfo->original_title;

            if ($moviedbId === null || is_numeric($moviedbId) === false) {
                throw new InvalidArgumentException("The field moviedb_id should be filled with an int", Response::HTTP_BAD_REQUEST);
            }

            if ($collectionName === null || is_string($collectionName) === false) {
                throw new InvalidArgumentException("The field collection_name should be filled with a string", Response::HTTP_BAD_REQUEST);
            }
            if ($originalTitle === null || is_string($originalTitle) === false) {
                throw new InvalidArgumentException("The field original_title should be filled with a string", Response::HTTP_BAD_REQUEST);
            }

            $vhs = new Vhs();
            $vhs->setCollectionName($collectionName);
            $vhs->setMoviedbId($moviedbId);
            $vhs->setOriginalTitle($originalTitle);

            $entityManager->persist($vhs);
            $entityManager->flush();

            return new JsonResponse(["message" => "Your vhs: " . $originalTitle . " has been added succesfully to your collection: " . $collectionName . ", yay!", "status" => Response::HTTP_CREATED], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage(), "status" => $e->getCode()], $e->getCode());
        }
    }
}
