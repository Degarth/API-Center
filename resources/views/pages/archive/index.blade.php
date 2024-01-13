@extends('layouts.app')

@section('title', 'Archive')

@section('content')
    <style>
        body {
            background-color: #0f232f;
            color:white;
        }
    </style>
    <div class="container mt-3">
        <div style="display: inline-block" class="col-12">
            <h1 style="display:inline">Archive</h1>
            <h2 style="display:inline;float:right; vertical-align: middle; margin-top: 5px; {{ (isset($sub) && $sub == 'movie') ? 'color:cadetblue !important;' : '' }}" class="{{  (isset($sub) && $sub == 'image') ? 'text-danger' : 'text-warning ' }}" >{{ $title ?? '' }}</h2>
            <br/>
            <form style="display: flex; gap: 5px;margin-top:5px" class="col-12"  action="{{ route('archive.search') }}" method="POST">
                @csrf
                <input name="title" type="text" class="form-control" value="{{ $title ?? '' }}">
                <span>Search for:</span>
                <button type="submit" name="submit" value="Books" class="btn btn-warning">Books</button>
                <button type="submit" name="submit" value="Movies" class="btn btn-warning" style="background-color: cadetblue; border-color: cadetblue; color: white">Movies</button>
                <button type="submit" name="submit" value="Images" class="btn btn-danger">Images</button>
            </form>
        </div>
        <hr>
        @if(isset($books))
            <div class="row">
                @foreach($books as $book)
                    <div class="col-12" style="border: 2px dotted darkgoldenrod; padding:10px; border-radius: 20px 0px 0px 10px; border-bottom: none;">
                        <h3>{{ $book['title'] }} <a href="{{ $book['url'] }}" target="_blank"><strong style="color:orange"><sub><em>Read</em></sub></strong></a></h3>
                        @if(is_array($book['creator']))
                            @foreach($book['creator'] as $creator)
                                <h5>{{ $creator ?? '' }}</h5>
                            @endforeach
                        @else
                            <h5>{{ $book['creator'] ?? '' }}</h5>
                        @endif
                        @if(is_array($book['description']))
                            @foreach($book['description'] as $bdesc)
                                <p>{{ $bdesc }}</p>
                            @endforeach
                        @elseif($book['description'] != null)
                            <p>{{ $book['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif(isset($movies))
            <div class="row">
               @foreach($movies as $movie)
                   <div class="col-12" style="border: 2px dotted cadetblue; padding:10px; border-radius: 20px 0px 0px 10px; border-bottom: none;">
                       <h3>{{ $movie['title'] }} <a href="{{ $movie['url'] }}" target="_blank"><strong style="color:cadetblue"><sub><em>Watch</em></sub></strong></a></h3>
                       @if(is_array($movie['creator']))
                           @foreach($movie['creator'] as $creator)
                               <h4>{{ $creator ?? '' }}</h4>
                           @endforeach
                       @else
                           <h4>{{ $movie['creator'] ?? '' }}</h4>
                       @endif
                       @if(is_array($movie['description']))
                           @foreach($movie['description'] as $description)
                               <p>{{ $description ?? '' }}</p>
                           @endforeach
                       @else
                           <p>{{ $movie['description'] ?? '' }}</p>
                       @endif
                   </div>
               @endforeach
            </div>
        @elseif(isset($images))
            <div class="row">
                @foreach($images as $image)
                    <div class="col-12" style="border: 2px dotted indianred; padding:10px; border-radius: 20px 0px 0px 10px; border-bottom: none;">
                        <h3>{{ $image['title'] }} <a href="{{ $image['url'] }}" target="_blank"><strong style="color:indianred"><sub><em>Inspect</em></sub></strong></a></h3>
                        @if(is_array($image['creator']))
                            @foreach($image['creator'] as $creator)
                                <h4>{{ $creator ?? '' }}</h4>
                            @endforeach
                        @else
                            <h4>{{ $image['creator'] ?? '' }}</h4>
                        @endif
                        @if(is_array($image['description']))
                            @foreach($image['description'] as $description)
                                <p>{{ $description ?? '' }}</p>
                            @endforeach
                        @else
                            <p>{{ $image['description'] ?? '' }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
