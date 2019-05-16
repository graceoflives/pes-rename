<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <title>My Project</title>

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 20px;
            font-weight: 400;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="page-header">
        <h1>My Project</h1>
    </div>
    <a class="btn btn-primary" href="{!! route('players.index') !!}">Players</a>
</div>
</body>
</html>
