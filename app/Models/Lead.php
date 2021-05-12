<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    public function form() {
        return $this->belongsTo('App\Models\Form');
    }

    public function answers() {
        return $this->hasMany('App\Models\Answer');
    }
}
