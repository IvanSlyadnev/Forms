<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'question_id',
        'lead_id'
    ];


    public function lead() {
        return $this->belongsTo(Lead::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
