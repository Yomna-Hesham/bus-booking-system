@extends("layouts.master")

@section("page-title", $name)

@section('local-styles')
    <link href="{{ URL::to('jquery-multiple-select/multi-select.css') }}" media="screen" rel="stylesheet" type="text/css">
@endsection

@section("content")
    @if(empty($data))
        {!! Form::open(['route' => strtolower($name).'.store']) !!}
    @else
        {!! Form::open(['route' => [strtolower($name).'.update', $data['id']], "method" => "PUT"]) !!}
    @endif

    @foreach($fields as $field => $metadata)
        {!! Form::label($field, $metadata['label']) !!}

        @switch($metadata['type'])
            @case('text')
                {!! Form::text($field, empty($data) ? null : $data[$field], ['class' => "form-control"]) !!}
                @break

            @case('select')
                {!! Form::select($metadata['multiple'] ? $field.'[]' : $field, $metadata['options'],
                                empty($data) ? null : $data[$field],
                                ['multiple' => $metadata['multiple'], 'class' => "form-control"]) !!}
                @break

            @case('date')
                {!! Form::datetimelocal($field, empty($data) ? null : Carbon::parse($data[$field]) , ['class' => "form-control"]) !!}
                @break
        @endswitch
        <br><br>
    @endforeach

    {!! Form::submit('Save') !!}

    {!! Form::close() !!}
@endsection

@section('local-scripts')
    <script src=" {{ URL::to('jquery-multiple-select/jquery-multi-select.js') }}" type="text/javascript"></script>
    <script>
        $('select[multiple]').multiSelect({ keepOrder: true });
    </script>
@endsection
