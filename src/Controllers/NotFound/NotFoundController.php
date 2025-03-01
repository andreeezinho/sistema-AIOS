<?php

namespace App\Controllers\NotFound;

use App\Controllers\Controller;

class NotFoundController extends Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        return $this->router->view('404/404', []);
    }

}