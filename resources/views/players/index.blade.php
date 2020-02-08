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
        <h1>Players</h1>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif
    {!! $players->links() !!}

    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Game ID</th>
            <th>Default Data</th>
            <th>Web Full Name</th>
            <th>Local Full Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($players as $player)
            <tr>
                <td>{!! $player->id !!}</td>
                <td>{!! $player->game_id !!}</td>
                <td>JAP: {!! join(' ', $player->full_name_japan_default) !!}<br>
                NAME: {!! $player->full_name_default !!}<br>
                SHIRT: {!! $player->shirt_name_default !!}</td>
                <td>{!! $player->full_name_web !!}</td>
                <td>{!! $player->full_name_local !!}</td>
                <td>
                    @if ($player->trashed())
                        <form method="POST" action="{!! route('players.restore', ['player' => $player->id]) !!}">
                            {{ csrf_field() }}
                            <div class="btn-group btn-group">
                                <a class="btn btn-primary"
                                   href="{!! route('players.edit', ['player' => $player->id]) !!}">Edit</a>
                                <button class="btn btn-success" onclick="return confirm('Are you sure?');">
                                    Restore
                                </button>
                            </div>
                        </form>
                    @else
                        <form method="POST" action="{!! route('players.destroy', ['player' => $player->id]) !!}">
                            {{ @method_field('DELETE') }}
                            {{ csrf_field() }}
                            <div class="btn-group btn-group">
                                <a class="btn btn-primary"
                                   href="{!! route('players.edit', ['player' => $player->id]) !!}">Edit</a>
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?');">
                                    Delete
                                </button>
                            </div>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
</body>
</html>