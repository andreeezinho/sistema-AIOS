<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Config\Auth;
use App\Repositories\User\UserRepository;

class DashboardController extends Controller {

    protected $auth;
    protected $userRepository;

    public function __construct(){
        parent::__construct();
        $this->auth = new Auth();
        $this->userRepository = new UserRepository();
    }

    public function index(){
        $user = $this->auth->user();

        $usuarios = $this->userRepository->all();

        return $this->router->view('dashboard/index', [
            'user' => $user,
            'usuarios' => $usuarios
        ]);
    }

}