<?php

namespace App\Services;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class JokeApiService {

    public function getResponse($url)
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];

        $client = new Client([
            'headers' => $headers
        ]);

        try {
            $response = $client->get($url);

            $body = $response->getBody()->getContents();
            $responseData = json_decode($body, true);
            return $responseData;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorMessage = $response->getBody()->getContents();

            return response()->json([
                'error' => $errorMessage,
                'status_code' => $statusCode,
            ], $statusCode);
        }
    }



}
