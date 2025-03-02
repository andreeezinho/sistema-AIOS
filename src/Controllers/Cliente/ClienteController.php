<?php

namespace App\Controllers\Cliente;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Cliente\ClienteRepository;

class ClienteController extends Controller {

    protected $clienteRepository;

    public function __construct(){
        parent::__construct();
        $this->clienteRepository = new ClienteRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $clientes = $this->clienteRepository->all($params);

        return $this->router->view('cliente/index', [
            'clientes' => $clientes
        ]);
    }

}