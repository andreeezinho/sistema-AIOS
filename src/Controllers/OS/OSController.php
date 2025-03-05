<?php

namespace App\Controllers\OS;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\OS\OSRepository;
use App\Repositories\Cliente\ClienteRepository;
use App\Repositories\User\UserRepository;

class OSController extends Controller {

    protected $OSRepository;
    protected $ClienteRepository;
    protected $UserRepository;

    public function __construct(){
        parent::__construct();
        $this->OSRepository = new OSRepository();
        $this->ClienteRepository = new ClienteRepository();
        $this->UserRepository = new UserRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $os = $this->OSRepository->all($params);

        return $this->router->view('os/index', [
            'all_os' => $os
        ]);
    }

}