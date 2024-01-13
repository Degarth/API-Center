<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WikiApiService;
use Carbon\Carbon;

class WikiController extends Controller
{
    protected $wiki;

    public function __construct(WikiApiService $wiki)
    {
        $this->wiki = $wiki;
    }

    public function index()
    {
        return view('pages.wiki.index');
    }

    public function onThisDay($set = null, $today = null)
    {
        $set = $set ?? 'selected';
        $today = $this->wiki->getDay($today);
        $data = $this->wiki->getTodaysData('https://api.wikimedia.org/feed/v1/wikipedia/en/onthisday/all/'.$today, $set);

        return view('pages.wiki.today', ['data' => $data, 'today' => $today, 'set' => $set]);
    }
}
