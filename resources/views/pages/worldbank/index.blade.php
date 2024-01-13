@extends('layouts.app')

@section('title', 'World Bank')

@section('content')
    <style>
        body, .card {
            background-color: #0f232f;
            color:white;
        }
        .card {
            border: 1px solid white;
        }
    </style>
    <div class="container mt-3">
        <form method="GET" action="{{ route('worldbank.search') }}">
            @csrf
            <h1>WB

                <small>
                    <select class="form-control" name="year" onchange="this.form.submit();">
                        @foreach($yearList as $key => $year)
                            <option value="{{ $year }}" {{ ($year == $selectedYear) ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </small>
            </h1>
            <h3>Country:
                <small>
                    <select class="form-control" name="country" onchange="this.form.submit();">
                        @foreach($countryList as $key => $country)
                            <option value="{{ $key }}" {{ ($key == $selectedCountry) ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </small>
            </h3>
        </form>
        <hr>
        @if(isset($data))
            <div class="row row-cols-2 g-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $data['gdp']['indicator'] }}</h3>
                            <hr>
                            <h3 class="card-text">{{ $data['gdp']['value'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $data['gni']['indicator'] }}</h3>
                            <hr>
                            <h3 class="card-text">{{ $data['gni']['value'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $data['population']['indicator'] }}</h3>
                            <hr>
                            <h3 class="card-text">{{ $data['population']['value'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $data['inflation']['indicator'] }}</h3>
                            <hr>
                            <h3 class="card-text">{{ $data['inflation']['value'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $data['forest']['indicator'] }}</h3>
                            <hr>
                            <h3 class="card-text">{{ $data['forest']['value'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $data['agriculture']['indicator'] }}</h3>
                            <hr>
                            <h3 class="card-text">{{ $data['agriculture']['value'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $data['literacy']['indicator'] }}</h3>
                            <hr>
                            <h3 class="card-text">{{ $data['literacy']['value'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $data['research']['indicator'] }}</h3>
                            <hr>
                            <h3 class="card-text">{{ $data['research']['value'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
