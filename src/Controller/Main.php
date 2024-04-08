<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Main extends AbstractController
{
    #[Route(path: '/', name: 'app_main')]
    public function main(Request $request): Response
    {
        if(!$request->headers->get('rabbitmq_token')) {
            return $this->redirectToRoute("app_main_homepage");
        } else {
            dump($request->headers);
            die();
        }
    }
    #[Route(path: '/homepage', name: 'app_main_homepage')]
    public function homepage(): Response
    {
        return $this->render("base.html.twig",[]);
    }
}