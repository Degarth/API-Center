<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SocialService;

class SocialController extends Controller
{
    protected $social;

    public function __construct(SocialService $social)
    {
        $this->social = $social;
    }

    public function index()
    {
        $data = $this->social->getAllData();
        $name = $this->social->getName();
        $email = $this->social->getEmail();
        //dd($data);

        return view('pages.social.index', ['data' => $data, 'name' => $name, 'email' => $email]);
    }
}
