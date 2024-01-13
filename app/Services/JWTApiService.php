<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class JWTApiService
{
    public function getResponse($url)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'X-API-KEY' => '925b61db-a3f6-4b17-93ba-849897d6324f'
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
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorMessage = $response->getBody()->getContents();

            return response()->json([
                'error' => $errorMessage,
                'status_code' => $statusCode,
            ], $statusCode);
        }
    }

    public function getData($id)
    {
        //dd($id);
        $data = $this->getResponse('https://api.jwstapi.com/program/id/'.$id);
        $data = $data['body'];
        //dd($data);
        return $data;
    }

    public function getPrograms()
    {
        $programs = $this->getResponse('https://api.jwstapi.com/program/list?');
        $programs = $programs['body'];
        //dd($programs);
        return $programs;
    }
}
