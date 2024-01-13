@extends('layouts.app')

@section('title', 'Notes')

@section('content')
    <div class="container mt-5">
        <h1>Brain Center</h1>
        <hr>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">APOD</h5>
                        <p class="card-text">A photo of the day by NASA</p>
                        <a href="/apod" class="btn btn-danger">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">ISS</h5>
                        <p class="card-text">ISS above Kaunas</p>
                        <a href="/iss" class="btn btn-primary">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jokes</h5>
                        <p class="card-text">Various jokes</p>
                        <a href="/joke" class="btn btn-warning">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">JWST</h5>
                        <p class="card-text">Raw Images of James Webb Telescope</p>
                        <a href="/jwt" class="btn btn-warning">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">NEOW</h5>
                        <p class="card-text">Near Earth Objects - 3D Simulation</p>
                        <a href="/neow" class="btn btn-dark">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Wiki</h5>
                        <p class="card-text">Wiki APIs</p>
                        <a href="/wiki" class="btn btn-light">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">GeoCities</h5>
                        <p class="card-text">Search GIF database</p>
                        <a href="/geocities" class="btn btn-warning">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Archive</h5>
                        <p class="card-text">Search for books, movies, images</p>
                        <a href="/archive" class="btn btn-secondary">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="cart-title">World Bank</h5>
                        <p class="card-text">Various data about a country</p>
                        <a href="/worldbank" class="btn btn-primary">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="cart-title">Social</h5>
                        <p class="card-text">Prototyping Social Network</p>
                        <a href="/social" class="btn btn-info">GO</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="cart-title">BioGen</h5>
                        <p class="card-text">Full data on a given animal</p>
                        <a href="/bio" class="btn btn-success">GO</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
