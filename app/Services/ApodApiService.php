<?php

namespace App\Services;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class ApodApiService
{
    public function getPicture()
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $client = new Client([
            'headers' => $headers
        ]);

        try {
            $response = $client->get('https://api.nasa.gov/planetary/apod?api_key=moYTJFPfhA5uo6QndUoDsj8z1j4dfhlW8cvrLk2f');

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
    public function getPictureByDate($date)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $client = new Client([
            'headers' => $headers
        ]);
        //dd('https://api.nasa.gov/planetary/apod?api_key=moYTJFPfhA5uo6QndUoDsj8z1j4dfhlW8cvrLk2f&date='.$date);
        try {
            $response = $client->get('https://api.nasa.gov/planetary/apod?api_key=moYTJFPfhA5uo6QndUoDsj8z1j4dfhlW8cvrLk2f&date='.$date);

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
