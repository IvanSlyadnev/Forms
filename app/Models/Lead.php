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

    public function chat() {
        return $this->hasOne(Chat::class, 'current_lead_id');
    }

    public function currentQuestion() {
        return $this->belongsTo(Question::class, 'current_question_id');
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    
}
