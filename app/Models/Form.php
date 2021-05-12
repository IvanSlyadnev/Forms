<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function leads() {
        return $this->hasMany('App\Models\Lead');
    }

    public function questoins() {
        return $this->hasMany('App\Models\Question');
    }

}
