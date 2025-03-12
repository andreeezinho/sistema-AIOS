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

    public function min($data, $min){
        if(strlen($data) < $min){
            return false;
        }

        return true;
    }

    public function email($data){
        if(!filter_var($data, FILTER_VALIDATE_EMAIL)){
            return false;
        }

        return true;
    }

}