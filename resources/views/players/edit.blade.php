<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>{{ $title }}</title>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <link href="{{ mix('/css/player.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container-fluid bg-dark">
    <div class="page-header">
        <h1>Player Edit</h1>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif
    <form method="POST" class="form-horizontal" action="{{ route('players.update', ['player' => $player->id]) }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
            <label class="control-label col-sm-2" for="game_id">Game ID</label>
            <div class="col-sm-10">
                <input id="game_id" name="game_id" class="form-control" readonly
                       value="{!! $player->game_id !!}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-success"
                   href="https://www.pesmaster.com/{!! Str::slug($player->full_name_default) !!}/pes-2017/player/{!! $player->game_id !!}"
                   target="_blank">View Web Info</a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="full_name_default">Default Name</label>
            <div class="col-sm-10">
                <input id="full_name_default" name="full_name_default" class="form-control" readonly
                       value="{!! $player->full_name_default !!}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="full_name_japan_default">Default Japan Name</label>
            <div class="col-sm-10">
                <input id="full_name_japan_default" name="full_name_japan_default" class="form-control" readonly
                       value="{!! join(' ', $player->full_name_japan_default) !!}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="shirt_name_default">Default Shirt Name</label>
            <div class="col-sm-10">
                <input id="shirt_name_default" name="shirt_name_default" class="form-control" readonly
                       value="{!! $player->shirt_name_default !!}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="full_name_web">Web Name</label>
            <div class="col-sm-10">
                <input id="full_name_web" name="full_name_web" class="form-control" readonly
                       value="{!! $player->full_name_web !!}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-success" onclick="$('#full_name_local').val($('#full_name_web').val());">Copy Web
                    Name to Local Name
                </button>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="full_name_local">Local Name</label>
            <div class="col-sm-10">
                <input id="full_name_local" name="full_name_local" class="form-control"
                       value="{!! $player->full_name_local !!}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="full_name_local">Local Shirtname</label>
            <div class="col-sm-10">
                <input id="full_name_local" name="shirt_name_local" class="form-control"
                       value="{!! $player->shirt_name_local !!}" maxlength="15">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input class="btn btn-primary" type="Submit" value="Save"/>
            </div>
        </div>
    </form>
</div>
</body>
</html>