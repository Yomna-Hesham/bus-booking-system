@extends("layouts.master")

@section("page-title", $name)

@section("content")
    @if(empty($data))
        <h2>
            No {{ $name }} Defined
        </h2>
    @else
        @include("layouts.table", $data)
    @endif
@endsection
