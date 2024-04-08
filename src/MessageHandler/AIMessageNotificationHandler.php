<?php

namespace App\MessageHandler;

use App\Message\AIMessageNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AIMessageNotificationHandler
{
    /**
     * @param AIMessageNotification $message
     * @return void
     * @throws GuzzleException
     */
    public function __invoke(AIMessageNotification $message): void
    {
        $client = new Client([
            'headers' => [
                'X-AUTH-TOKEN' => 'admin',
                'Accept' => 'application/json',
            ]
        ]);

        $client->post($_ENV['CONTENT_HUB_SERVICE_ADDRESS'] . '/admin/api/ais/articles?action=queue',[
            'json' => $message->getContent()
        ]);
    }

}