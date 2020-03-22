<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("layouts.head")
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/"><h1>ADMIN</h1></a>
        </nav>

        @if(isset($name))
            <a class="navbar-brand" href="{{ route(strtolower($name).".index") }}"><h2>{{ strtoupper($name) }}</h2></a>
{{--            <h1 class="navbar-brand"></h1>--}}
        @endif

        <div class="container">
            @yield("content")
        </div>

        @include("layouts.modal")
        @include("assets.scripts")
    </body>
</html>
