<?php

namespace App\Services;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class ISSApiService
{
    public function getResponse($url)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $client = new Client([
            'headers' => $headers
        ]);

        try {
            $response = $client->get($url);

            $body = $response->getBody()->getContents();
            $responseData = json_decode($body, true);
            return $responseData[0];
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

    public function isVisible($data)
    {
        if(isset($data))
            if($data['visible'])
                return '<span style="color:yellowgreen">Visible</span>';
            else
                return '<span style="color:red">Not Today</span>';
        else
            return 'Data not found';
    }

    public function isSunlit($data)
    {
        if(isset($data)) {
            $data['rise']['is_sunlit'] = $data['rise']['is_sunlit'] ? '<span style="color:yellowgreen">Yes</span>' : '<span style="color:yellowgreen">No</span>';
            $data['culmination']['is_sunlit'] = $data['culmination']['is_sunlit'] ? '<span style="color:yellowgreen">Yes</span>' : '<span style="color:yellowgreen">No</span>';
            $data['set']['is_sunlit'] = $data['set']['is_sunlit'] ? '<span style="color:yellowgreen">Yes</span>' : '<span style="color:yellowgreen">No</span>';

            return $data;
        }
        else
            return 'Data not found';
    }

    public function dateFormat($data)
    {
        $data['rise']['utc_datetime'] = substr($data['rise']['utc_datetime'], 0, 19);
        $data['culmination']['utc_datetime'] = substr($data['culmination']['utc_datetime'], 0, 19);
        $data['set']['utc_datetime'] = substr($data['set']['utc_datetime'], 0, 19);

        return $data;
    }

}
