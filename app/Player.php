<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'game_id',
        'game_binary_default',
        'full_name_default',
        'shirt_name_default',
        'full_name_web',
        'full_name_local',
        'shirt_name_local'
    ];

    /**
     * Accessor: game_binary_default
     * @param $value
     * @return string
     */
    public function getGameBinaryDefaultAttribute($value)
    {
        $_local_1 = unpack('H*', $value);
        $_local_2 = join('', $_local_1);
        $_local_3 = strtoupper($_local_2);
        $_local_4 = str_split($_local_3, 2);
        $_local_5 = join(' ', $_local_4);
        return $_local_5;
    }

    public function getFullNameJapanDefaultAttribute()
    {
        $_local_1 = explode(' ', $this->game_binary_default);
        $_local_2 = collect(array_slice($_local_1, 52, 46));
        $_local_3 = $_local_2->map(function ($i) {
            return chr(hexdec($i));
        });
        $_local_4 = $_local_3->implode('');
        $_local_5 = explode(' ', trim($_local_4));
        return $_local_5;
    }
}
