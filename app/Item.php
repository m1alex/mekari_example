<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    
    protected $fillable = [
        'title',
    ];
    
    public static $rules = [
        'title' => 'required|string|max:64',
    ];
}
