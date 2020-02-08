<?php

namespace App\Http\Controllers;

use App\Player;
use App\PlayerYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Sunra\PhpSimple\HtmlDomParser;

class PlayerController extends Controller
{
    public function __construct()
    {
        View::share('title', 'Players');
    }

    public function index()
    {
        $players = Player::withTrashed()->paginate(50);
//        dd($players->first()->full_name_japan_default);
        return View::make('players.index')
            ->with('players', $players);
    }

//    public function loadDefault()
//    {
//        if (Storage::exists('sample.bin')) {
//            $player_data = Storage::get('sample.bin');
//            $player_data_unpack = collect(unpack('C*', $player_data));
//            $player_data_unpack = $player_data_unpack->chunk(192);
//            $player_data_unpack->each(function ($player) {
//                $_game_id = $player->slice(8, 4)->values()->transform(function ($item, $key) {
//                    return $item * 256 ** $key;
//                })->sum();
//                $_shirt_name_default = trim($player->slice(98, 46)->map(function ($i) {
//                    return chr($i);
//                })->implode(''));
//                $_full_name_default = trim($player->slice(144, 47)->map(function ($i) {
//                    return chr($i);
//                })->implode(''));
//                $row = new Player([
//                    'game_id' => $_game_id,
//                    'shirt_name_default' => $_shirt_name_default,
//                    'full_name_default' => $_full_name_default,
//                    'full_name_web' => '',
//                    'full_name_local' => ''
//                ]);
//                $row->save();
//            });
//        }
//    }

//    public function loadBlobDefault()
//    {
//        if (Storage::exists('sample.bin')) {
//            $player_data = Storage::get('sample.bin');
//            $player_data_unpack = collect(unpack('C*', $player_data));
//            $player_data_unpack = $player_data_unpack->chunk(192);
//            $player_data_unpack->each(function ($player, $key) {
//                $row = Player::withTrashed()->find($key + 1);
//                $_binary = pack('C*', ...$player);
//                $row->game_binary_default = $_binary;
//                $row->save();
//            });
//        }
//    }

//    public function crawl()
//    {
//        if (Storage::exists('latest.txt')) {
//            $id = (int)Storage::get('latest.txt') + 1;
//        } else {
//            $id = 1;
//        }
//
//        $options = [
//            'ssl' => [
//                'verify_peer' => false,
//                'verify_peer_name' => false
//            ]
//        ];
//        stream_context_set_default($options);
//
//        $player = Player::withTrashed()->find($id);
//        if ($player) {
//            $url = 'https://pesmaster.com/a-christensen/pes-2017/player/' . $player->game_id;
//            $html = HtmlDomParser::file_get_html($url);
//
//            if ($html) {
//                $_full_name = substr($html->find('h2.mobile-no', 0)->innertext(), 0, -15);
//                $player->full_name_web = $_full_name;
//                $player->save();
//                echo('Saved player ' . $player->game_id . ' (' . $player->full_name_default . ')!' . PHP_EOL);
//            } else {
//                echo('Player ' . $player->game_id . ' not found!' . PHP_EOL);
//            }
//            Storage::put('latest.txt', $id);
//            return $player;
//        } else {
//            echo('Player ' . $player->game_id . ' not found!' . PHP_EOL);
//            return null;
//        }
//    }

    public function buildBinary()
    {
        $players = Player::orderBy('id', 'asc')->get();
        $updatedHexes = $players->map(function ($player) {
            $hexFull = unpack('H*', $player->getOriginal('game_binary_default'))[1];
            $hexName = unpack('H*', (strlen($player->full_name_local) === 0) ? $player->full_name_default : $player->full_name_local);
            $hexName = str_pad($hexName[1], 94, '0');
            $hexShirtName = unpack('H*', (strlen($player->shirt_name_local) === 0) ? $player->shirt_name_default : $player->shirt_name_local);
            $hexShirtName = str_pad($hexShirtName[1], 90, '0');
            $updatedHexFull = substr_replace($hexFull, $hexName, 288, strlen($hexName));
            $updatedHexFull = substr_replace($updatedHexFull, $hexShirtName, 196, strlen($hexShirtName));
            return $updatedHexFull;
        });
        $fullHex = $updatedHexes->implode('');
        $fullBinary = pack('H*', $fullHex);
        $file = 'Sample_' . date('YmdHis') . '.bin';
        Storage::put($file, $fullBinary);
        echo 'DONE!';
    }

//    public function buildPlayerYear()
//    {
//        $players = Player::orderBy('game_id', 'asc')->get();
//        $players->each(function ($player) {
//            $playerYear = new PlayerYear();
//            $playerYear->game_id = $player->game_id;
//            $playerYear->year = 2017;
//            $playerYear->game_binary_default = $player->getOriginal('game_binary_default');
//            $playerYear->full_name_local = $player->full_name_local;
//            $playerYear->save();
//        });
//    }

    public function edit($id)
    {
        $player = Player::withTrashed()->find($id);

        if (!$player) {
            Session::flash('message', 'Player not found');
            return redirect()->route('players.index');
        }

        return View::make('players.edit')->with('player', $player);
    }

    public function update(Request $request, $id)
    {
        $player = Player::withTrashed()->find($id);

        if ($player) {
            $player->full_name_local = $request->input('full_name_local');
            $player->shirt_name_local = strtoupper($request->input('shirt_name_local'));
            $player->save();
            Session::flash('message', 'Player updated successfully');
        } else {
            Session::flash('message', 'Player not found');
        }
        return redirect()->route('players.edit', ['player' => $id + 1]);
    }

    public function destroy($id)
    {
        $player = Player::withTrashed()->find($id);

        if ($player) {
            $player->delete();
            Session::flash('message', 'Player deleted successfully');
        } else {
            Session::flash('message', 'Player not found');
        }
        return redirect()->route('players.index');
    }

    public function restore($id)
    {
        $player = Player::onlyTrashed()->find($id);

        if ($player) {
            $player->restore();
            Session::flash('message', 'Player restored successfully');
        } else {
            Session::flash('message', 'Player not found');
        }
        return redirect()->route('players.index');
    }
}
