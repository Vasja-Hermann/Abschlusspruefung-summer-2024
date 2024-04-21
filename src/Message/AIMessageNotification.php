<?php

namespace App\Message;


use App\Entity\AiArticle;
use OpenAI;

class AIMessageNotification
{

    public function __construct(private readonly AiArticle $data)
    {

    }

    public function getContent(): array
    {
        $data = $this->data;
        $result = [];
        if($data instanceof AiArticle) {
            try {
                $quantity = 5;
                if($data->getQuantity() > 0 && $data->getQuantity() !== 5) {
                    $quantity = $data->getQuantity();
                }

                $apiKey = $_ENV['OPENAI_API_KEY'];
                $client = OpenAI::client($apiKey);
                $result[] = [
                    "texts" => $client->chat()->create([
                        'model' => 'gpt-4',
                        'messages' => [
                            ['role' => 'user', 'content' => $data->getPrompt() . "\n" . $data->getText()],
                        ],
                        'n' => $quantity
                    ])->choices,
                    'tenant' => $data->getTenant(),
                    'locale' => "de",
                    'parentUuid' => $data->getParentUuid()
                ];
            } catch (\Exception $exception) {

            }
        }
        return $result;
    }
}