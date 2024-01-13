<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WikiApiService
{
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

    public function getTodaysData($url, $set)
    {
        $response = $this->getResponse($url);
        $data = array();
        foreach($response[$set] as $key => $record)
        {
            $data[$key]['text'] = $record['text'];
            if($set != 'holidays')
                $data[$key]['year'] = $record['year'];
            foreach($record['pages'] as $detail)
            {
                if(isset($detail['thumbnail']))
                    $data[$key]['img'][] = $detail['thumbnail']['source'];
            }
        }

        return $data;
    }

    public function getDay($today)
    {
        return ($today == null) ? $today = Carbon::now()->format('m/d') : $today = str_replace('-', '/', $today);
    }
}
