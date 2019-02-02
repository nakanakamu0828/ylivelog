<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Scripts --}}
        {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
        <script src="/js/app.js" defer></script>

        {{-- Styles --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        <link rel="stylesheet" href="/css/app.css">

        {{-- Icon --}}
        {{-- <link rel="icon" href="{{ asset('favicon.ico') }}"> --}}
        <link rel="icon" href="/favicon.ico'">

    </head>
    <body class="text-black bg-grey-lighter">
        <div
            id="app"
            @if (Auth::check()) data-user='{!! Auth::user()->toJson() !!}' @endif
        ></div>
    </body>
</html>
