<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TrainingService;

class TrainingController extends Controller
{
    protected $training;

    public function __construct(TrainingService $training)
    {
        $this->training = $training;
    }

    public function index()
    {
        $data = $this->training->gravity();
        dd($data);
        return view('pages.training.index');
    }
}
