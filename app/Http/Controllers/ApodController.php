<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApodApiService;

class ApodController extends Controller
{
    protected $apodData;

    public function __construct(ApodApiService $apodData)
    {
        $this->apodData = $apodData;
    }

    public function index()
    {
        $data = $this->apodData->getPicture();
        return view('pages.nasa.apod.index', ['data' => $data]);
    }

    public function byDate(Request $request)
    {
        $date = $request->input('date');
        $data = $this->apodData->getPictureByDate($date);

        return view('pages.nasa.apod.index', ['data' => $data]);
    }
}
