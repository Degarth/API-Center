<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NeoWApiService;

class NeoWController extends Controller
{
    protected $neow;

    public function __construct(NeoWApiService $neow)
    {
        $this->neow = $neow;
    }

    public function index($page = 0)
    {
        $data = $this->neow->getData($page);
        return view('pages.nasa.neow.index', ['data' => $data, 'page' => $page]);
    }

    public function globe($page = 0, $id = null)
    {
        if($id == null)
            $data = $this->neow->getData($page);
        else
            $data = $this->neow->getDataOne($page, $id);

        return view('pages.nasa.neow.globe', ['data' => $data, 'page' => $page]);
    }
}
