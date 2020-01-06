<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nfe extends Model
{

    public $table = 'nfes';

    protected $fillable = [
        'xml_content',
        'total_value',
        'access_key'
    ];

    public $timestamps = true;
}
