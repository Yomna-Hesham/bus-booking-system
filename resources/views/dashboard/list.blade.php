@extends("layouts.master")

@section("page-title", $name)

@section("local-styles")
    <style>
        .create{
            margin: 50px;
        }
    </style>
@endsection

@section("content")
    <div class="row justify-content-end align-items-end">
        <div class="col align-self-end order-12">
            <a href="{{ route(strtolower($name).'.create') }}"><button class="btn btn-success btn-lg create">Create</button></a>
        </div>
    </div>
    @if(empty($data) || empty($data['body']))
        <h2>
            No {{ $name }} Defined
        </h2>
    @else
        @include("layouts.table", $data)
    @endif
@endsection
