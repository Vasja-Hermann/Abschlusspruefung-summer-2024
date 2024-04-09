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
        return $this->redirectToRoute("access_token_list");
    }
}