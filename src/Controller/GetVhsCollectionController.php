<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vhs;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class GetVhsCollectionController extends AbstractController
{
    #[Route('/collection/{collection}', name: 'get_vhs_collection', methods: ["GET"])]
    #[Route('/collection', name: 'get_all_vhs', methods: ["GET"])]
    public function getVhsCollection(EntityManagerInterface $entityManager, $collection = ""): Response
    {
        try {

            if ($collection == "") {
                $vhsList =  $entityManager->getRepository(Vhs::class)->findAll();
            } else {
                $vhsList = $entityManager->getRepository(Vhs::class)->findBy(["collection_name" => $collection]);
            }

            $vhsFormattedList = [];
            foreach ($vhsList as $vhs) {
                $vhsFormatted = ["id" => $vhs->getId(), "moviedbId" => $vhs->getMoviedbId(), "collectionName" => $vhs->getCollectionName(), "originalTitle" => $vhs->getOriginalTitle()];
                array_push($vhsFormattedList, $vhsFormatted);
            }

            return new JsonResponse($vhsFormattedList);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage(), "status" => $e->getCode()], $e->getCode());
        }
    }
}
