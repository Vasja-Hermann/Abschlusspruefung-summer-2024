<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Message\AIMessageNotification;
use Symfony\Component\Messenger\MessageBusInterface;

class AiArticleProcessor implements ProcessorInterface
{
    private MessageBusInterface $bus;
    public function __construct(MessageBusInterface $bus) {
        $this->bus = $bus;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {

        $this->bus->dispatch(new AIMessageNotification($data));
    }



}