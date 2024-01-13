<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeoCitiesApiService;

class GeoCitiesController extends Controller
{
    protected $oi;

    public function __construct(GeoCitiesApiService $oi)
    {
        $this->oi = $oi;
    }

    public function index()
    {
        $data = $this->oi->getResponse('api.giphy.com/v1/gifs/trending?api_key=JBZuWQWZHsF7zuppYTDR2htXliUVp2Jw');
        $embeds = $this->oi->getEmbeds($data['data']);

        return view('pages.geocities.index', ['embeds' => $embeds]);
    }

    public function search(Request $request)
    {
        $string = $request->input('searchbox');

        $data = $this->oi->getResponse('https://api.giphy.com/v1/gifs/search?api_key=JBZuWQWZHsF7zuppYTDR2htXliUVp2Jw&q='.$string);
        $embeds = $this->oi->getEmbeds($data['data']);

        return view('pages.geocities.index', ['embeds' => $embeds, 'string' => $string]);
    }
}
