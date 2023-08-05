<!doctype html>
<html lang="en-GB">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Collector</title>

        <link rel="stylesheet" href="{{ asset_url('main.css') }}">
        <link rel="icon" href="{{ asset_url('favicon.ico') }}">
        <link rel="manifest" href="{{ asset_url('manifest.json') }}">

        {{ $head ?? null }}

    </head>
    <body>

        {{ $slot }}

    </body>
</html>
