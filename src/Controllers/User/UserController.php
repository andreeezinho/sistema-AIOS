<?php

namespace App\Controllers\User;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\User\UserRepository;

class UserController extends Controller {

    protected $userRepository;

    public function __construct(){
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request){
        if(!userPermission('visualizar usuarios')){
            return $this->router->redirect('');
        }

        $params = $request->getQueryParams();

        $usuarios = $this->userRepository->all($params);

        return $this->router->view('user/index', [
            'usuarios' => $usuarios
        ]);
    }

    public function create(Request $request){
        if(!userPermission('cadastrar usuarios')){
            return $this->router->redirect('');
        }

        return $this->router->view('user/create', [
            'perfil' => false
        ]);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        $data['icone'] = 'default.png';
    
        if($data['nome'] == "" || $data['email'] == ""  || $data['cpf'] == ""){
            return $this->router->view('user/create', [
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $create = $this->userRepository->create($data);

        if(is_null($create)){
            return $this->router->view('user/create', [
                'erro' => 'Não foi possível criar usuário'
            ]);
        }

        return $this->router->redirect('usuarios');
    }

    public function edit(Request $request, $uuid){
        if(!userPermission('editar usuarios')){
            return $this->router->redirect('');
        }
        
        $usuario = $this->userRepository->findByUuid($uuid);

        if(!$usuario){
            return $this->router->redirect('');
        }

        return $this->router->view('user/edit', [
            'perfil' => false,
            'usuario' => $usuario
        ]);
    }

    public function update(Request $request, $uuid){
        $usuario = $this->userRepository->findByUuid($uuid);

        if(!$usuario){
            return $this->router->redirect('');
        }

        $data = $request->getBodyParams();

        if($data['nome'] == "" || $data['email'] == "" || $data['cpf'] == ""){
            return $this->router->view('user/edit', [
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $update = $this->userRepository->update($data, $usuario->id);

        if(is_null($update)){
            return $this->router->view('user/index', [
                'erro' => 'Não foi possível editar usuário'
            ]);
        }

        return $this->router->redirect('usuarios');

    }

    public function destroy(Request $request, $uuid){
        if(!userPermission('deletar usuarios')){
            return $this->router->view('user/index', [
                'erro' => 'Você não tem as permissões necessárias'
            ]);
        }

        $usuario = $this->userRepository->findByUuid($uuid);

        if(!$usuario){
            return $this->router->redirect('usuarios');
        }

        $delete = $this->userRepository->delete($usuario->id);

        if(!$delete){
            return $this->router->view('user/index', [
                'erro' => 'Não foi possível excluir usuário'
            ]);
        }

        return $this->router->redirect('usuarios');
    }

    public function login(){
        $auth = new Auth();

        if($auth->check()){
            return $this->router->redirect('dashboard');
        }

        return $this->router->view('login/login', []);
    }

    public function auth(Request $request){
        $data = $request->getBodyParams();

        $user = $this->userRepository->login($data['email'], $data['senha']);

        $auth = new Auth();

        if($auth->login($user)){
            return $this->router->redirect('dashboard');
        }

        return $this->router->view('login/login', [
            'erro' => 'Usuário não encontrado'
        ]);
    }

    public function logout(){
        $auth = new Auth();
        $auth->logout();
        
        return $this->router->redirect('login');
    }

}