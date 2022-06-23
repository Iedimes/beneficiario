<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impresion extends Model
{
    protected $fillable = [
        'ci',
        'fecha_impresion',


    ];


    //  protected $dates = [
    //      'created_at',
    //      'updated_at',

    //  ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/impresions/'.$this->getKey());
    }
}
