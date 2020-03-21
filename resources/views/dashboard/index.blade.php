@extends("layouts.master")

@section("page-title", "Dashboard")

@section("content")
        <div class="flex-center position-ref full-height">
            <a href="{{ route('buses.index') }}"><button>Buses</button></a>
            <button>Trips</button>
            <button>Tickets</button>
        </div>
@endsection
