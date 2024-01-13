<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ISSApiService;
use Carbon\Carbon;

class ISSController extends Controller
{
    protected $iss;

    public function __construct(ISSApiService $iss)
    {
        $this->iss = $iss;
    }

    public function index()
    {
        $data = $this->iss->getResponse('https://satellites.fly.dev/passes/25544?lat=54.9138387&lon=23.9408512&limit=1');
        $data['visible'] = $this->iss->isVisible($data);
        $data = $this->iss->isSunlit($data);
        $data = $this->iss->dateFormat($data);

        return view('pages.nasa.iss.index', ['data' => $data]);
    }
}
