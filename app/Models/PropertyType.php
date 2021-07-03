<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = ['id', 'title', 'description'];

    public function property()
    {

        return $this->hasMany('App\Models\Property');

    }

}
