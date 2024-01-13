@extends('layouts.app_neo')

@section('title', 'NeoW')

@section('content')
    <style>
        table, thead, tbody, tr, th, td {
            color:white;
            border-color:white;
        }
        .dataTables_length, .dataTables_filter {
            margin-bottom: 15px !important; /* Adjust the margin as needed */
        }
        #neoTable.dataTable {
            border-collapse: collapse; /* Use your preferred border-collapse style */
            border-spacing: 0; /* Use your preferred border-spacing style */
            border: 1px solid #ddd; /* Use your preferred border style */
        }

        /* Override DataTables styles for table header cells */
        #neoTable.dataTable thead th {
            border: 1px solid #ddd; /* Use your preferred header cell border style */
            background-color: #0f232f; /* Use your preferred header background color */
        }

        /* Override DataTables styles for table body cells */
        #neoTable.dataTable tbody td {
            border: 1px solid #ddd; /* Use your preferred body cell border style */
        }
    </style>
    <div class="container mt-4">
        <div class="row">
            <div style="display: inline-block">
                <h1 style="display:inline;float:left">NeoW - Near Earth Objects</h1>
                <a href="{{ route('neow', ['page' => $page+1]) }}" class="btn btn-primary" style="display:inline;float:right;margin-left:5px">Next</a>
                <a href="{{ $page - 1 < 0 ? '#' : route('neow', ['page' => $page - 1]) }}" class="btn btn-primary" style="display:inline;float:right; @unless($page - 1 >= 0) pointer-events: none; color: #b6b6b6; @endunless">Previous</a>
            </div>
            <hr/>


                <a href="{{ route('neow.globe', ['page' => $page]) }}" class="btn btn-success" style="display:inline;float:right;margin-right:5px; margin-bottom:10px">ALL NEAR EARTH OBJECT 3D ORBIT SIMULATION</a>

            <div class="table-responsive">
                <table class="table table-bordered" id="neoTable" data-page-length="20">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Diameter Min Max (KM)</th>
                            <th scope="col">Close Approach Date</th>
                            <th scope="col">Relative Velocity (KM/S)</th>
                            <th scope="col">Miss Distance (KM)</th>
                            <th scope="col">Orbit Class</th>
                            <th scope="col">IPHA</th>
                            <th scope="col">3D Orbit Simulation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $info)
                            <tr>
                                <td>{{ $info['id'] }}</td>
                                <td nowrap>{{ $info['name'] }}</td>
                                <td>{{ $info['estimated_diameter_min']}} - {{ $info['estimated_diameter_max'] }}</td>
                                <td>{{ $info['close_approach_date_full'] }}</td>
                                <td>{{ $info['relative_velocity'] }}</td>
                                <td>{{ $info['miss_distance'] }}</td>
                                <td>{{ $info['orbit_class_type'] }}</td>
                                <td>{!! $info['is_potentially_hazardous_asteroid'] !!}</td>
                                <td><a href="{{ route('neow.globe', ['page' => $page, 'id' => $info['id']]) }}" class="btn btn-success">GO</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            $('#neoTable').DataTable({
                paging: false
            });
        } );
    </script>
@endsection
