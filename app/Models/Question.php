<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'form_id'
    ];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function createQuestion($form, $data) {
        return $form->questions()->create($data);
    }

    public function updateQuestion($form, $data) {
        return $form->questions()->where('id', $this->id)->update($data);
    }

}
