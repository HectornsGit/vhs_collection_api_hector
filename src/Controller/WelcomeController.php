<?php
#Basic controller to check if the application is live.
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class WelcomeController extends AbstractController
{
    #[Route(path: "/", name: "welcome", methods: ["GET"])]
    public function welcoming(Request $request): Response
    {
        $name = $request->query->get("name", "Earth inhabitant");
        return new JsonResponse(["message" => "Welcome, " . $name . "!", "status" => Response::HTTP_OK], Response::HTTP_OK);
    }
}
