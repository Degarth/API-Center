@extends('layouts.app')

@section('title', 'JWT')

@section('content')
    <div class="container mt-5">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>JWST - RAW IMAGES</h1>
            <form style="display: flex; gap: 5px;" method="POST" action="{{ route('jwt.show') }}">
                @csrf
                <select class="form-control" name="program">
                    @foreach ($programs as $program)
                        <option value="{{ $program['program'] }}">{{ $program['program'] }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Get</button>
            </form>
        </div>
        <hr>
        @if(isset($data))
            @foreach($data as $img)
                @if($img['file_type'] == 'jpg')
                    <img style="max-width: 600px" src="{{ $img['location'] }}">
                @endif
            @endforeach
        @endif
    </div>
@endsection
