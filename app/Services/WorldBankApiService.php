<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WorldBankApiService
{
    public function getResponse($url)
    {
        $headers = [
            'Content-type' => 'application/json'
        ];

        $client = new Client([
            'headers' => $headers
        ]);

        try {
            $response = $client->get($url);
            $body = $response->getBody()->getContents();
            $responseData = json_decode($body, true);
            //dd($responseData);
            return $responseData[1];
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

    public function getGDP($id, $year)
    {
        return $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/NY.GDP.MKTP.CD?date='.$year.'&format=json')[0];
    }

    public function getPopulation($id, $year)
    {
        return $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/SP.POP.TOTL?date='.$year.'&format=json')[0];
    }

    public function getInflation($id, $year)
    {
        $thisYear = $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/FP.CPI.TOTL?date='.$year.'&format=json')[0];
        $lastYear = $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/FP.CPI.TOTL?date='.($year-1).'&format=json')[0];

        $inflation = number_format((($thisYear['value']-$lastYear['value']) / $lastYear['value'])*100, 2);

        return $inflation;
    }

    public function getLiteracy($id, $year)
    {
        return $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/SE.ADT.LITR.ZS?date='.$year.'&format=json')[0];
    }

    public function getForestArea($id, $year)
    {
        return $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/AG.LND.FRST.ZS?date='.$year.'&format=json')[0];
    }

    public function getGNI($id, $year)
    {
        return $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/NY.GNP.MKTP.CD?date='.$year.'&format=json')[0];
    }

    public function getAgriculture($id, $year)
    {
        return $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/AG.LND.AGRI.ZS?date='.$year.'&format=json')[0];
    }

    public function getResearch($id, $year)
    {
        return $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/GB.XPD.RSDV.GD.ZS?date='.$year.'&format=json')[0];
    }

    public function getAllIndicatorData($year, $id)
    {
        $gdp = $this->getGDP($id, $year);
        $gni = $this->getGNI($id, $year);
        $population = $this->getPopulation($id, $year);
        $inflation = $this->getInflation($id, $year);
        $forestArea = $this->getForestArea($id, $year);
        $literacy = $this->getLiteracy($id, $year);
        $agriculture = $this->getAgriculture($id, $year);
        $research = $this->getResearch($id, $year);


        $data['gdp']['indicator'] = $gdp['indicator']['value'];
        $data['gdp']['value'] = $gdp['value'].'$';

        $data['population']['indicator'] = $population['indicator']['value'];
        $data['population']['value'] = $population['value'];

        $data['inflation']['indicator'] = 'Inflation';
        $data['inflation']['value'] = $inflation.'%';

        $data['forest']['indicator'] = $forestArea['indicator']['value'];
        $data['forest']['value'] = number_format($forestArea['value'], 2).'%';

        $data['literacy']['indicator'] = $literacy['indicator']['value'];
        $data['literacy']['value'] = $literacy['value'].'%';

        $data['gni']['indicator'] = $gni['indicator']['value'];
        $data['gni']['value'] = $gni['value'].'$';

        $data['agriculture']['indicator'] = $agriculture['indicator']['value'];
        $data['agriculture']['value'] = $agriculture['value'].'%';

        $data['research']['indicator'] = $research['indicator']['value'];
        $data['research']['value'] = $research['value'];

        $data = collect($data);
        //dd($data);

        return $data;
    }

    public function getYearList($id)
    {
        $yearList = array();

        $data = $this->getResponse('https://api.worldbank.org/v2/country/'.$id.'/indicator/NY.GDP.MKTP.CD?format=json');

        foreach($data as $record)
        {
            $yearList[] = $record['date'];
        }

        return $yearList;
    }

    public function getCountryList()
    {
        $countries = $this->getResponse('http://api.worldbank.org/v2/country?format=json&per_page=300&source=2');

        $countryList = array();

        foreach($countries as $country)
        {
            $countryList[$country['iso2Code']] = $country['name'].($country['capitalCity'] != null ? ' - ' : '').$country['capitalCity'];
        }

        return $countryList;
    }
}
