<?php

namespace App\Controllers\Venda;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Cliente\ClienteRepository;

class VendaController extends Controller {

    public $vendaRepository;
    public $usuarioRepository;
    public $clienteRepository;

    public function __construct(){
        parent::__construct();
        $this->vendaRepository = new VendaRepository();
        $this->usuarioRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $vendas = $this->vendaRepository->all($params);

        return $this->router->view('venda/index', [
            'vendas' => $vendas
        ]);
    }

}