@extends('layouts.app')

@section('title', 'Wiki')

@section('content')
    <div class="container mt-5">
        <h1>Wiki</h1>
        <hr>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">On This Day</h5>
                        <a href="/wiki-today" class="btn btn-success">See</a>
                    </div>
                </div>
            </div>
            <div class="col">

            </div>
            <div class="col">

            </div>
        </div>
    </div>
@endsection
