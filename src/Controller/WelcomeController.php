<?php
#Basic controller to check if the application is live.
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends AbstractController
{
    #[Route(path: "/welcome", name: "welcome", methods: ["GET"])]
    public function welcoming(Request $request): Response
    {
        $name = $request->query->get("name", "Héctor");
        return new Response("Welcome, " . $name . "!", Response::HTTP_OK);
    }
}
