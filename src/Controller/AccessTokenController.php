<?php

namespace App\Controller;

use App\Entity\AccessToken;
use App\Form\AccessToken\AccessTokenType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class AccessTokenController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/access/token/","access_token_list")]
    public function list(): Response
    {
        $accessTokens = $this->entityManager->getRepository(AccessToken::class)->findAll();
        return $this->render("accessToken/list.html.twig", [
            'accessTokens' => $accessTokens,
        ]);
    }

    #[Route("/access/token/create","access_token_create")]
    public function create(Request $request): Response
    {
        $accessToken = new AccessToken();
        $accessTokenForm = $this->createForm(AccessTokenType::class, $accessToken, [
            'type' => "create"
        ]);
        $accessTokenForm->handleRequest($request);

        if($accessTokenForm->isSubmitted() && $accessTokenForm->isValid()){
            $tokenBase = Uuid::v4();
            $tokenBase64 = base64_encode($tokenBase);
            $accessToken->setToken($tokenBase64);
            $accessToken->setValid(true);
            $this->entityManager->persist($accessToken);
            $this->entityManager->flush();

            return $this->redirectToRoute("access_token_list");
        }

        return $this->render("accessToken/create.html.twig", [
            'accessTokenForm' => $accessTokenForm->createView(),
        ]);
    }

    #[Route("/access/token/update/{accessToken}","access_token_update")]
    public function update(AccessToken $accessToken, Request $request): Response
    {
        $accessTokenForm = $this->createForm(AccessTokenType::class, $accessToken, [
            'type' => "update"
        ]);
        $accessTokenForm->handleRequest($request);

        if($accessTokenForm->isSubmitted() && $accessTokenForm->isValid()){
            $this->entityManager->persist($accessToken);
            $this->entityManager->flush();

            return $this->redirectToRoute("access_token_list");
        }

        return $this->render("accessToken/create.html.twig", [
            'accessTokenForm' => $accessTokenForm->createView(),
        ]);
    }


    #[Route("/access/token/invalidate/{accessToken}","access_token_invalidate")]
    public function invalidate(AccessToken $accessToken): Response
    {
        $accessToken->setValid(!$accessToken->isValid());
        $this->entityManager->persist($accessToken);
        $this->entityManager->flush();

        return $this->redirectToRoute("access_token_list");
    }


}