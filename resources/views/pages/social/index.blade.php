@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <style>
        body {
            background-color: #2d3748;
            color: white;
        }
    </style>
    <div class="container mt-3">
        {{-- @include('inc.nav') --}}
        <h1>Home</h1>
        <h3>{{ $name }}</h3>
        <h5>{{ $email }}</h5>
        <h5>{{ $data->city }}</h5>
        <h5>{{ $data->phone }}</h5>
        <h5>{{ $data->job }}</h5>
    </div>
@endsection
