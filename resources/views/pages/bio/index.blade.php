@extends('layouts.app')

@section('title', 'BioGen')

@section('content')
    <style>
        body {
            background-color: #2d3748;
            color: white;
        }
    </style>
    <div class="container mt-3">
        <h1>BioGen - Animal Database</h1>
        <form action="{{ route('bio.info') }}" method="GET" class="form-inline d-flex">
            <input type="text" name="animal" class="me-1">
            <button type="submit" class="btn btn-success btn-sm">Search Animal</button>
        </form>
        <hr>
        @if(isset($data))
            @foreach($data as $record)
                @foreach($record as $key => $point)
                    @if($key == 'name')
                        <h2 style="color: rgb(193, 254, 70); border: 1px solid white; padding:5px; text-align:center">{{ $point }}</h2>
                    @elseif($key == 'taxonomy')
                        <h4 style="color:rgb(244, 151, 151); text-decoration: underline">{{ ucfirst($key) }}</h4>
                        <table>
                            <tbody>
                                @foreach($point as $taxonomy => $value)
                                    <tr>
                                        <td style="padding-right: 10px; float:right"><b class="ms-5">{{ ucfirst(str_replace("_", " ", $taxonomy)) }}:</b></td>
                                        <td style="border-left:1px solid white; padding-left: 10px">{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($key == 'locations')
                        <h4 style="color:rgb(254, 254, 194);text-decoration: underline">{{ ucfirst($key) }}</h4>
                        @foreach($point as $location)
                            <b class="ms-5">{{ ucfirst($location) }}</b><br/>
                        @endforeach
                    @elseif($key == 'characteristics')
                        <h4 style="color:rgb(171, 195, 250);text-decoration: underline">{{ ucfirst($key) }}</h4>
                        <table>
                            <tbody>
                                @foreach($point as $characteristic => $value)
                                    <tr>
                                        <td style="padding-right: 10px; float:right"><b class="ms-5">{{ ucfirst(str_replace("_", " ", $characteristic)) }}:</b></td>
                                        <td style="border-left:1px solid white; padding-left: 10px">{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endforeach
                    <hr>
            @endforeach
        @endif
    </div>
@endsection
