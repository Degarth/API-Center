<?php

namespace App\Services;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Carbon\Carbon;

class NeoWApiService
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

    public function formatData($data)
    {
        $neoData = [];
        foreach ($data as $info) {
            $neoData[] = [
                'id' => $info['id'],
                'name' => $info['name'],
                'estimated_diameter_min' => number_format($info['estimated_diameter']['kilometers']['estimated_diameter_min'], 2),
                'estimated_diameter_max' => number_format($info['estimated_diameter']['kilometers']['estimated_diameter_max'], 2),
                'orbit_class_type' => $info['orbital_data']['orbit_class']['orbit_class_type'],
                'is_potentially_hazardous_asteroid' => $info['is_potentially_hazardous_asteroid'] ? '<span style="color:red">YES</span>' : '<span style="color:lightgreen">NO</span>',
                'close_approach_date_full' => ''
            ];
        }
        return $neoData;
    }

    public function nextApproach($neoData, $data)
    {
        foreach($neoData as $key => $info) {
            $closestDate = null; // Initialize a variable to keep track of the closest date
            foreach($info['close_approach_data'] as $cad) {
                foreach($data as &$nd) {
                    if ($info['id'] == $nd['id']) {
                        $approachDate = Carbon::parse($cad['close_approach_date_full']);
                        if(Carbon::now() < $approachDate && ($closestDate === null || $approachDate < $closestDate)) {
                            $closestDate = $approachDate;
                            $nd['close_approach_date_full'] = $cad['close_approach_date_full'];
                            $nd['relative_velocity'] = number_format($cad['relative_velocity']['kilometers_per_second'],2);
                            $nd['miss_distance'] = number_format($cad['miss_distance']['kilometers'], 2);
                            $nd['orbital_data'] = $info['orbital_data'];
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function getData($page)
    {
        $response = $this->getResponse('http://api.nasa.gov/neo/rest/v1/neo/browse?page='.$page.'&size=20&api_key=moYTJFPfhA5uo6QndUoDsj8z1j4dfhlW8cvrLk2f');
        $neoData = $response['near_earth_objects'];
        $data = $this->formatData($neoData);
        $data = $this->nextApproach($neoData, $data);

        return $data;
    }

    public function getDataOne($page, $id)
    {
        $response = $this->getResponse('http://api.nasa.gov/neo/rest/v1/neo/browse?page='.$page.'&size=20&api_key=moYTJFPfhA5uo6QndUoDsj8z1j4dfhlW8cvrLk2f');
        $neoData = $response['near_earth_objects'];
        $data = $this->formatData($neoData);
        $data = $this->nextApproach($neoData, $data);
        $dataOne = array();
        foreach($data as $record)
        {
            if($record['id'] == $id)
                $dataOne[0] = $record;
        }
        //dd($dataOne);

        return $dataOne;
    }
}
