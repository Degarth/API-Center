<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JokeApiService;

class JokeController extends Controller
{
    protected $joke;

    public function __construct(JokeApiService $joke)
    {
        $this->joke = $joke;
    }

    public function index()
    {
        $data = $this->joke->getResponse('https://v2.jokeapi.dev/joke/Any');
        //dd($data);
        return view('pages.jokes.index', ['data' => $data]);
    }

    public function newJoke()
    {
        return redirect()->back();
    }


}
