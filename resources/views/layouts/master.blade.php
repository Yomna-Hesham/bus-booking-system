<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("layouts.head")
    <body>
        @yield("content")

        @include("layouts.modal")
        @include("assets.scripts")
    </body>
</html>