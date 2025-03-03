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

    public function create(Request $request){
        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        return $this->router->view('venda/create', [
            'cadastro' => true,
            'clientes' => $clientes
        ]);
    }

    public function store(Request $request){
        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        $data = $request->getBodyParams();

        $cliente = $this->clienteRepository->findByUuid($data['cliente']);

        $create = $this->vendaRepository->create($data, $_SESSION['user']->id, $cliente->id);

        if(is_null($create)){
            return $this->router->view('venda/create', [
                'erro' => 'Não foi possível cadastrar a venda',
                'cadastro' => true,
                'clientes' => $clientes
            ]);
        }

        return $this->router->redirect('vendas/'. $create->uuid . '/produtos');
    }

}