<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\AccessToken;
use App\Message\AIMessageNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;

class AiArticleProcessor implements ProcessorInterface
{
    private MessageBusInterface $bus;

    private RequestStack $requestStack;

    private EntityManagerInterface $entityManager;
    public function __construct(MessageBusInterface $bus, RequestStack $requestStack, EntityManagerInterface $entityManager) {
        $this->bus = $bus;
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if(array_key_exists('rabbitmq-token', $request->headers->all()) && $this->entityManager->getRepository(AccessToken::class)->findValidToken($request->headers->get('rabbitmq-token'))) {
            $this->bus->dispatch(new AIMessageNotification($data));
        }
    }



}