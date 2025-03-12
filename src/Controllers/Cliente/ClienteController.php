<?php

namespace App\Controllers\Cliente;

use App\Request\Request;
use App\Controllers\Controller;
use App\Controllers\Traits\Validator;
use App\Repositories\Cliente\ClienteRepository;

class ClienteController extends Controller {

    protected $clienteRepository;

    use Validator;

    public function __construct(){
        parent::__construct();
        $this->clienteRepository = new ClienteRepository();
    }

    public function index(Request $request){
        if(!userPermission('visualizar clientes')){
            return $this->router->redirect('');
        }

        $params = $request->getQueryParams();

        $clientes = $this->clienteRepository->all($params);

        return $this->router->view('cliente/index', [
            'clientes' => $clientes
        ]);
    }

    public function create(Request $request){
        if(!userPermission('cadastrar clientes')){
            return $this->router->redirect('');
        }

        return $this->router->view('cliente/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        if(!$this->required($data, ['nome', 'email', 'documento', 'telefone'])){
            return $this->router->view('cliente/create', [
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $create = $this->clienteRepository->create($data);

        if(is_null($create)){
            return $this->router->view('cliente/create', [
                'erro' => 'Não foi possível criar o cliente'
            ]);
        }

        return $this->router->redirect('clientes');
    }

    public function edit(Request $request, $uuid){
        if(!userPermission('editar clientes')){
            return $this->router->redirect('');
        }

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

        if(!$this->required($data, ['nome', 'email', 'documento', 'telefone'])){
            return $this->router->view('cliente/edit', [
                'cliente' => $cliente,
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $update = $this->clienteRepository->edit($data, $cliente->id);

        if(is_null($update)){
            return $this->router->view('cliente/edit', [
                'cliente' => $cliente,
                'erro' => 'Não foi possível criar o cliente'
            ]);
        }

        return $this->router->redirect('clientes');
    }

    public function destroy(Request $request, $uuid){
        if(!userPermission('deletar clientes')){
            return $this->router->redirect('');
        }

        $cliente = $this->clienteRepository->findByUuid($uuid);

        if(!$cliente){
            return $this->router->redirect('clientes');
        }

        $delete = $this->clienteRepository->delete($cliente->id);

        if(!$delete){
            return $this->router->view('cliente/index', [
                'erro' => 'Não foi possível deletar o cliente'
            ]);
        }

        return $this->router->redirect('clientes');
    }

}