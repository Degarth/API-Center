@extends('layouts.app')

@section('title', 'Jokes')

@section('content')
    <style>
        .blur {
            background-color: rgba(255, 0, 0, 0.5);
            filter: blur(5px);
            padding: 6px;
        }
    </style>

    <div class="container mt-5">
        <h1>A Joke</h1>
        <a class="btn btn-primary" href="{{ route('new.joke') }}">New Joke</a>
        <hr/>
        @if($data['type'] == 'single')
            <h3>{{ $data['joke'] }}</h3>
        @else
            <h3>{{ $data['setup'] }}</h3>
            <div id="reveal" class="blur" onClick="deliver()">
                <h2>{{ $data['delivery'] }}</h2>
            </div>
        @endif
    </div>

    <script>
        function deliver() {
            var element = document.getElementById("reveal");
            console.log(element);
            element.classList.remove("blur");
        }
    </script>
@endsection
