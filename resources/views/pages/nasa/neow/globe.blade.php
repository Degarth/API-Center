@extends('layouts.app_neo')

@section('title', 'NeoW-Globe')

@section('content')
    <style>

    </style>
    <div class="container mt-4">
        <div class="row">
            <div style="display: inline-block">
                <h1 style="display:inline">NeoW-Globe</h1>
                <a href="{{ route('neow.globe', ['page' => $page+1]) }}" class="btn btn-primary" style="display:inline;float:right;margin-left:5px">Next</a>
                <a href="{{ $page - 1 < 0 ? '#' : route('neow', ['page' => $page - 1]) }}" class="btn btn-primary" style="display:inline;float:right; @unless($page - 1 >= 0) pointer-events: none; color: #b6b6b6; @endunless">Previous</a>
            </div>
            <hr/>
            <div id="neoWScene" style="border: 1px solid white;width: 100%; height: 800px; overflow: hidden"></div>
        </div>
    </div>



    <!-- Embed NeoW data as a JSON object -->
    <script type="application/json" id="neoWData">
        @json($data)
    </script>

    <script type="module" src="{{ asset('js/main.js') }}"></script>
@endsection
