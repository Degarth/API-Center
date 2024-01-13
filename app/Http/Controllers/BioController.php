<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BioApiService;

class BioController extends Controller
{
    protected $bio;

    public function __construct(BioApiService $bio)
    {
        $this->bio = $bio;
    }

    public function index()
    {
        return view('pages.bio.index');
    }

    public function info(Request $request)
    {
        $animal = $request->input('animal');
        $data = $this->bio->getResponse('https://api.api-ninjas.com/v1/animals?name='.$animal);

        return view('pages.bio.index', ['data' => $data]);
    }
}
