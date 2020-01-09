<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nfe extends Model
{

    public $table = 'nfes';

    protected $fillable = [
        'xml_content',
        'access_key',
        'total_value',
    ];

    public $timestamps = true;
}
