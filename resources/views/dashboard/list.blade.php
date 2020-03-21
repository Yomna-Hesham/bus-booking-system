@extends("layouts.master")

@section("page-title", $name)

@section("content")
    <a href="{{ route('buses.create') }}"><button>Create</button></a>
    @if(empty($data) || empty($data['body']))
        <h2>
            No {{ $name }} Defined
        </h2>
    @else
        @include("layouts.table", $data)
    @endif
@endsection
