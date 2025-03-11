<?php

namespace App\Controllers\Traits;

trait Validator {

    public function required(array $data, $field){
        foreach($field as $campo){
            if(empty($data[$campo]) || $data[$campo] == ""){
                return false;
            }
        }

        return true;
    }

    public function min($data, $field, $lenght){
        
    }

}