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

class AddVhsToCollectionController extends AbstractController
{
    #[Route('/collection', name: 'add_movie_to_collection', methods: ["POST"])]
    public function addVhsToCollection(Request $request, EntityManagerInterface $entityManager): Response
    {

        $moviedbId = $request->get("moviedb_id");
        $collectionName = $request->get("collection_name");
        try {
            if ($moviedbId === null || is_numeric($moviedbId) === false) {
                throw new InvalidArgumentException("The field moviedb_id should be filled with an int", Response::HTTP_BAD_REQUEST);
            }
            if ($collectionName === null || is_string($collectionName) === false) {
                throw new InvalidArgumentException("The field collection_name should be filled with a string", Response::HTTP_BAD_REQUEST);
            }


            $vhs = new Vhs();
            $vhs->setCollectionName($collectionName);
            $vhs->setMoviedbId($moviedbId);

            $entityManager->persist($vhs);
            $entityManager->flush();

            return new JsonResponse(["message" => "Your vhs has been added succesfully to" . $collectionName . ", yay!", "status" => Response::HTTP_CREATED], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage(), "status" => $e->getCode()], $e->getCode());
        }
    }
}