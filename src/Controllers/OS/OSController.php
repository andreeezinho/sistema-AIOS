<?php

namespace App\Controllers\OS;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\OS\OSRepository;
use App\Repositories\Cliente\ClienteRepository;
use App\Repositories\User\UserRepository;

class OSController extends Controller {

    protected $osRepository;
    protected $clienteRepository;
    protected $userRepository;

    public function __construct(){
        parent::__construct();
        $this->osRepository = new OSRepository();
        $this->clienteRepository = new ClienteRepository();
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $os = $this->osRepository->all($params);

        return $this->router->view('os/index', [
            'all_os' => $os
        ]);
    }

    public function create(Request $request){
        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        return $this->router->view('os/create', [
            'cadastro' => true,
            'clientes' => $clientes
        ]);
    }

    public function store(Request $request){
        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        $data = $request->getBodyParams();

        $cliente = $this->clienteRepository->findByUuid($data['cliente']);

        $create = $this->osRepository->create($data, $_SESSION['user']->id, $cliente->id);

        if(is_null($create)){
            return $this->router->view('os/create', [
                'erro' => 'Não foi possível cadastrar a O.S',
                'cadastro' => true,
                'clientes' => $clientes
            ]);
        }

        return $this->router->redirect('os/'. $create->uuid . '/produtos');
    }

}