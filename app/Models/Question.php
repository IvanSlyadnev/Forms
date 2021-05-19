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
        'values'
    ];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function updateQuestion($form, $data) {
        return $form->questions()->where('id', $this->id)->update($data);
    }

}
