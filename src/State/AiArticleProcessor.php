<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\AccessToken;
use App\Message\AIMessageNotification;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;

class AiArticleProcessor implements ProcessorInterface
{
    private MessageBusInterface $bus;

    private EntityManagerInterface $entityManager;

    public function __construct(MessageBusInterface $bus, EntityManagerInterface $entityManager) {
        $this->bus = $bus;
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     * @throws Exception
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $request = $context["request"];

        if(array_key_exists('rabbitmq-token', $request->headers->all())
            && $this->entityManager->getRepository(AccessToken::class)->findValidToken($request->headers->get('rabbitmq-token'))) {
            $this->bus->dispatch(new AIMessageNotification($data));
        }
    }



}