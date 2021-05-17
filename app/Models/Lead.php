<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lead extends Model
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'form_id',
        'email'
    ];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
