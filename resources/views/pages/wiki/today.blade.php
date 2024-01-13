@extends('layouts.app')

@section('title', 'Wiki-Today')

@section('content')
    <div class="container mt-3 mb-3">
        <h1>Wiki Today <sub>{{ $today }} - {{ $set }}</sub></h1>
        <div class="row row-cols-1 row-cols-md-6 g-4">
            @foreach($data as $record)
                <div class="col">
                    <div class="card h-100">

                            {{--@foreach($record['img'] as $img)--}}
                                <img src="{{ $record['img'][0] ?? '' }}" class="card-img-top" alt="No Photo">
                            {{--@endforeach--}}

                        <div class="card-body">
                            <h5 class="card-title">{{ $record['year'] ?? '' }}</h5>
                            <p class="card-text">{{ $record['text'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
