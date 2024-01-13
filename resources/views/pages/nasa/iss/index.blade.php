@extends('layouts.app')

@section('title', 'ISS')

@section('content')
    <div class="container mt-3">
        <h1>ISS - Fly By - Kaunas - (54.8985° N, 23.9036° E)</h1>
        <hr/>
        <h2>Is visible: {!! $data['visible'] !!}</h2>
        <hr/>
        <h3>Rise: {{ $data['rise']['utc_datetime'] }}</h3>
        <h3>Is sunlit: {!! $data['rise']['is_sunlit'] !!}</h3>
        <hr/>
        <h3>Culmination: {{ $data['culmination']['utc_datetime'] }}</h3>
        <h3>Is sunlit: {!! $data['culmination']['is_sunlit'] !!}</h3>
        <hr/>
        <h3>Set: {{ $data['set']['utc_datetime'] }}</h3>
        <h3>Is sunlit: {!! $data['set']['is_sunlit'] !!}</h3> 
    </div>
@endsection
