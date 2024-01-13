@extends('layouts.app')

@section('title', 'Adop - '.$data['title'])

@section('content')
    <div class="container mt-3">
        <h1>APOD - A Picture of the Day</h1>

        <form method="POST" action="{{ route('submit.date') }}">
            @csrf
            <div class="mb-2">
                <input style="display:inline-block; width: 90%" class="form-control" name="date" type="date" value="{{ $data['date'] }}">
                <button style="" class="btn btn-primary" type="submit">Submit</button>
            </div>
            <h3 class="mb-3">{{ $data['title'] }}</h3>
            <img style="max-width: 600px" src="{{ $data['hdurl'] }}" alt="{{ $data['title'] }}">
        </form>
        <p>Description:<br/>{{ $data['explanation'] }}</p>
    </div>
@endsection
