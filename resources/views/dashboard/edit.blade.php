@extends("layouts.master")

@section("page-title", $name)

@section("content")
    @if(empty($data))
        {!! Form::open(['route' => strtolower($name).'.store']) !!}
    @else
        {!! Form::open(['route' => [strtolower($name).'.update', $data['id']], "method" => "PUT"]) !!}
    @endif

    @foreach($fields as $field => $label)
        {!! Form::label($field, $label) !!}
        {!! Form::text($field, empty($data) ? null : $data[$field]) !!}
    @endforeach

    {!! Form::submit('Save') !!}

    {!! Form::close() !!}
@endsection
