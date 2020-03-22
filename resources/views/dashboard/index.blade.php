@extends("layouts.master")

@section("page-title", "Dashboard")

@section("content")
        <div class="flex-center position-ref full-height">
            <div style="margin: 70px;">
                <a href="{{ route('buses.index') }}"><button class="btn btn-dark btn-lg">Buses</button></a>
            </div>

            <div style="margin: 70px;">
                <a href="{{ route('trips.index') }}"><button class="btn btn-dark btn-lg">Trips</button></a>
            </div>

            <div style="margin: 70px;">
                <a href="{{ route('tickets.index') }}"><button class="btn btn-dark btn-lg">Tickets</button></a>
            </div>
        </div>
@endsection
