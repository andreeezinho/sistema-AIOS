<?php

namespace App\Models\Traits;

trait Uuid {

    function generateUUID(){

        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);

        $data[8] = chr(ord($data) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}