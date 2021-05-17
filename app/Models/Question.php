<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

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

    public function getValuesArrayAttribute () {

        $collection = collect(
            explode(',', $this->values)
        );
        
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item => $item];
        });

        return $keyed->all();

    
    }

}
