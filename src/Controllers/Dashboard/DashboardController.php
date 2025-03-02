<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Config\Auth;
use App\Repositories\User\UserRepository;
use App\Repositories\Cliente\ClienteRepository;

class DashboardController extends Controller {

    protected $auth;
    protected $userRepository;
    protected $clienteRepository;

    public function __construct(){
        parent::__construct();
        $this->auth = new Auth();
        $this->userRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
    }

    public function index(){
        $user = $this->auth->user();

        $usuarios = $this->userRepository->all();
        $clientes = $this->clienteRepository->all();

        return $this->router->view('dashboard/index', [
            'user' => $user,
            'usuarios' => $usuarios,
            'clientes' => $clientes
        ]);
    }

}