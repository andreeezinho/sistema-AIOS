<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Config\Auth;
use App\Repositories\User\UserRepository;
use App\Repositories\Cliente\ClienteRepository;
use App\Repositories\Servico\ServicoRepository;

class DashboardController extends Controller {

    protected $auth;
    protected $userRepository;
    protected $clienteRepository;
    protected $servicoRepository;

    public function __construct(){
        parent::__construct();
        $this->auth = new Auth();
        $this->userRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
        $this->servicoRepository = new ServicoRepository();
    }

    public function index(){
        $user = $this->auth->user();

        $usuarios = $this->userRepository->all();
        $clientes = $this->clienteRepository->all();
        $servicos = $this->servicoRepository->all();

        return $this->router->view('dashboard/index', [
            'user' => $user,
            'usuarios' => $usuarios,
            'clientes' => $clientes,
            'servicos' => $servicos
        ]);
    }

}