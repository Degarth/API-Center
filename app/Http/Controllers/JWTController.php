<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JWTApiService;

class JWTController extends Controller
{
    protected $jwt;

    public function __construct(JWTApiService $jwt)
    {
        $this->jwt = $jwt;
    }

    public function index()
    {
        $programs = $this->jwt->getPrograms();

        return view('pages.nasa.jwt.index', ['programs' => $programs]);
    }

    public function show(Request $request)
    {
        $id = $request->input('program');
        $data = $this->jwt->getData($id);
        $programs = $this->jwt->getPrograms();

        return view('pages.nasa.jwt.index', ['data' => $data, 'programs' => $programs]);
    }
}
