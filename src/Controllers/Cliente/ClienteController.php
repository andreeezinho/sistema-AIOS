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

    public function create(Request $request){
        return $this->router->view('cliente/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        $create = $this->clienteRepository->create($data);

        if(is_null($create)){
            return $this->router->view('cliente/create', [
                'erro' => 'Não foi possível criar o cliente'
            ]);
        }

        return $this->router->redirect('clientes');
    }

    public function edit(Request $request, $uuid){
        $cliente = $this->clienteRepository->findByUuid($uuid);

        if(!$cliente){
            return $this->router->redirect('clientes');
        }

        return $this->router->view('cliente/edit', [
            'cliente' => $cliente
        ]);
    }

    public function update(Request $request, $uuid){
        $cliente = $this->clienteRepository->findByUuid($uuid);

        if(!$cliente){
            return $this->router->redirect('clientes');
        }

        $data = $request->getBodyParams();

        $update = $this->clienteRepository->edit($data, $cliente->id);

        if(is_null($update)){
            return $this->router->view('cliente/edit', [
                'erro' => 'Não foi possível criar o cliente'
            ]);
        }

        return $this->router->redirect('clientes');
    }

}