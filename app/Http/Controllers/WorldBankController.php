<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WorldBankApiService;

class WorldBankController extends Controller
{
    protected $bank;

    public function __construct(WorldBankApiService $bank)
    {
        $this->bank =  $bank;
    }

    public function index()
    {
        $users = [
            ['name' => 'John', 'age' => 25],
            ['name' => 'Jane', 'age' => 30],
            ['name' => 'Alice', 'age' => 28]
        ];

        $users = collect($users);

        //dd($users->where('age', '<', 30));
        $countryList = $this->bank->getCountryList();

        $country = session('country') ?? 'LT';
        $year = session('year') ?? '2021';

        $data = $this->bank->getAllIndicatorData($year, $country);
        $yearList = $this->bank->getYearList($country);

        if(isset($data))
            return view('pages.worldbank.index', ['data' => $data, 'yearList' => $yearList, 'countryList' => $countryList, 'selectedCountry' => $country, 'selectedYear' => $year]);
        else
            return view('pages.worldbank.index', ['yearList' => $yearList, 'countryList' => $countryList]);
    }

    public function search(Request $request)
    {
        $year = $request->input('year') ?? '2022';
        $country = $request->input('country');

        return redirect('/worldbank')->with(['country' => $country, 'year' => $year]);
    }

}
