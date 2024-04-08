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
                $apiKey = $_ENV['OPENAI_API_KEY'];
                $client = OpenAI::client($apiKey);
                $result[] = [
                    "texts" => $client->chat()->create([
                        'model' => 'gpt-4',
                        'messages' => [
                            ['role' => 'user', 'content' => $data->getPrompt() . "\n" . $data->getText()],
                        ],
                        'n' => $data->getQuantity()
                    ])->choices,
                    'tenant' => $data->getTenant(),
                    'locale' => $data->getLocale(),
                    'parentUuid' => $data->getParentUuid()
                ];
            } catch (\Exception $exception) {

            }
        }
        return $result;
    }
}