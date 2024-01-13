<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BioApiService
{
    public function getResponse($url)
    {
        $headers = [
            'Content-Type' => 'application\json',
            'X-Api-Key' => 'zhjgyfkVgYQrCq4E9Iv3LA==sLb8ACyUZ16mO7SQ',
        ];

        $client = new Client([
            'headers' => $headers
        ]);

        try {
            $response = $client->get($url);
            $body = $response->getBody()->getContents();
            $responseData = json_decode($body, true);
            return $responseData;
        } catch(RequestException $e) {
            $response = $e->response();
            $statusCode = $response->getstatusCode();
            $errorMessage = $response->getBody()->getContents();
            return response()->json([
                'error' => $errorMessage,
                'status' => $statusCode,
            ], $statusCode);
        }

    }
}
