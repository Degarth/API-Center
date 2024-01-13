<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SQLService;


class SQLController extends Controller
{
    protected $sqlbox;

    public function __construct(SQLService $sqlbox)
    {
        $this->sqlbox = $sqlbox;
    }

    public function index()
    {
        $getAll = $this->sqlbox->GetAll();
        dd($getAll);
        return view('pages.sql.index');
    }
}
