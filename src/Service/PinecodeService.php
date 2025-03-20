<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PineconeService
{
    private HttpClientInterface $client;
    private string $apiKey;
    private string $indexName;

    public function __construct(HttpClientInterface $client, string $apiKey, string $indexName)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->indexName = $indexName;
    }

    public function indexDocument(string $id, array $vector)
    {
        $url = "https://{$this->indexName}.svc." . $_ENV['PINECONE_ENVIRONMENT'] . ".pinecone.io/v1/vectors/upsert";
        
        $response = $this->client->request('POST', $url, [
            'headers' => [
                'Api-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'vectors' => [
                    ['id' => $id, 'values' => $vector]
                ]
            ],
        ]);

        return $response->getContent();
    }
}
