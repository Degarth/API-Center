<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Redirect;

class ArchiveApiService
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

    public function searchBooks($rawTitle): array
    {
        $title = preg_replace('/(?<!^) (?<!$)/', '+', $rawTitle);
        $data = $this->getResponse('https://archive.org/advancedsearch.php?q='.$title.'&output=json');
        //dd($data['response']['docs']);
        $books[] = array();
        $num = 0;
        foreach($data['response']['docs'] as $record) {
            if ($record['mediatype'] == 'texts')
            {
                //dd($record);
                $books[$num]['creator'] = $record['creator'] ?? '';
                $books[$num]['title'] = $record['title'] ?? '';
                $books[$num]['identifier'] = $record['identifier'] ?? '';
                $books[$num]['description'] = $record['description'] ?? '';
                $books[$num]['url'] = 'https://archive.org/stream/'.$record['identifier'];
                $num++;
            }
        }
        //dd($books);
        return $books;
    }

    public function searchMovies($rawTitle)
    {
        $title = preg_replace('/(?<!^) (?<!$)/', '+', $rawTitle);
        $data = $this->getResponse('https://archive.org/advancedsearch.php?q='.$title.'&output=json');
        $movies[] = array();
        $num = 0;
        foreach($data['response']['docs'] as $record) {
            if($record['mediatype'] == 'movies') {
                $record_data = $this->getResponse('https://archive.org/metadata/'.$record['identifier']);
                $found = false;
                $almostfound = false;
                foreach($record_data['files'] as $record_file) {
                    if(!$found) {
                        if (substr($record_file['name'], -4) === ".mp4" ) {
                            $url = 'https://archive.org/download/' . $record['identifier'] . '/' . $record_file['name'];
                            $found = true;
                        } elseif ($record_file['format'] == 'MPEG4') {
                            $url = 'https://archive.org/download/' . $record['identifier'] . '/' . $record_file['name'];
                            $almostfound = true;
                        } else {
                            $url = 'File Not Found';
                        }
                    }
                }
                $movies[$num]['creator'] = $record['creator'] ?? '';
                $movies[$num]['title'] = $record['title'] ?? '';
                $movies[$num]['identifier'] = $record['identifier'] ?? '';
                $movies[$num]['url'] = $url ?? '';
                $movies[$num]['description'] = $record['description'] ?? '';
                $num++;

                /*$record_data = $this->getResponse('https://archive.org/metadata/'.$record['identifier']);
                foreach($record_data['files'] as $record_file) {
                    if(substr($record_file['name'], -4) === ".mp4") {
                        $redirectURL = 'https://archive.org/download/' . $record['identifier'] . '/' . $record_file['name'];
                        header('Location: ' . $redirectURL);
                        exit;
                    }
                }*/
            }
        }
        //dd($movies);
        return $movies;
    }

    public function searchImages($rawTitle)
    {
        $title = preg_replace('/(?<!^) (?<!$)/', '+', $rawTitle);
        $data = $this->getResponse('https://archive.org/advancedsearch.php?q='.$title.'&output=json');
        //dd($data['response']['docs']);
        $images[] = array();
        $num = 0;
        foreach($data['response']['docs'] as $record) {
            if ($record['mediatype'] == 'image') {
                $record_data = $this->getResponse('https://archive.org/metadata/'.$record['identifier']);
                $found = false;;
                foreach($record_data['files'] as $record_file) {
                    if ($record_file['format'] == 'JPEG') {
                        $url = 'https://archive.org/download/' . $record['identifier'] . '/' . $record_file['name'];
                    }
                }

                $images[$num]['creator'] = $record['creator'] ?? '';
                $images[$num]['title'] = $record['title'] ?? '';
                $images[$num]['identifier'] = $record['identifier'] ?? '';
                $images[$num]['url'] = $url ?? '';
                $images[$num]['description'] = $record['description'] ?? '';
                $num++;
            }
        }
        return $images;
    }
}
