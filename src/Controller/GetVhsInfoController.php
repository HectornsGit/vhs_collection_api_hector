<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vhs;
use InvalidArgumentException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetVhsInfoController extends AbstractController
{
    #[Route('/vhs/{id}', name: 'get_vhs_information', methods: ["GET"])]

    public function getVhsInfo(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, $id = null): JsonResponse
    {
        try {
            if ($id == false) {
                throw new InvalidArgumentException("Sorry, we couldn't find what you were looking for", 404);
            }

            $vhs = $entityManager->getRepository(Vhs::class)->find(intval($id));

            if ($vhs === null) {
                throw new InvalidArgumentException("Sorry, we couldn't find what you were looking for", 404);
            }

            $vhsInformation =  fetchMovieFromMovieDbById($vhs->getMovieDbId(), $httpClient);

            return new JsonResponse(["data" => $vhsInformation, "status" => Response::HTTP_OK], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage(), "status" => $e->getCode()], $e->getCode());
        }
    }
}
