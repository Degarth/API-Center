@extends('layouts.app')

@section('title', 'Old Internet')

@section('content')
    <style>
        body {
            background-color: #0f232f;
            color:white;
        }
    </style>
    <!--MAIN-->
    <div class="container mt-3">
        <div style="display: inline-block" class="col-12">
            <h1 style="display:inline">2000.</h1>
            <h2 style="display:inline;float:right; vertical-align: middle; margin-top: 5px" class="text-warning">{{ $string ?? '' }}</h2>
            <br/>
            <form style="display: flex; gap: 5px;margin-top:5px" class="col-4"  action="{{ route('geocities.search') }}" method="POST">
                @csrf
                <input name="searchbox" type="text" class="form-control">
                <button type="submit" class="btn btn-warning">Search</button>
            </form>
        </div>
        <hr>
        <div class="row row-cols-1 row-cols-md-6 g-4">
            @foreach($embeds as $embed)
                <div class="col">
                    <embed src="{{ $embed }}">
                </div>
            @endforeach
        </div>
    </div>
@endsection
