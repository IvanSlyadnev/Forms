<?php

namespace App\Models;

use App\Traits\HasValuesArray;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasValuesArray;

    protected $fillable = [
        'question',
        'form_id',
        'type',
        'values',
        'file'
    ];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function leads() {
        return $this->hasMany(Lead::class, 'current_question_id');
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function chats() {
        return $this->belongsToMany(Chat::class)->withPivot('answer');
    }

}
