<?php
namespace App\Traits;

trait HasValuesArray {
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