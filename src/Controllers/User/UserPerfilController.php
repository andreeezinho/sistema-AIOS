<?php

namespace App\Controllers\User;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Traits\Validator;
use App\Controllers\Controller;
use App\Repositories\User\UserRepository;

class UserPerfilController extends Controller {

    protected $auth;
    protected $userRepository;
    protected $usuario;

    use Validator;

    public function __construct(){
        parent::__construct();
        $this->userRepository = new UserRepository;
        $this->auth = new Auth();
        $this->usuario = $_SESSION['user'] ?? null;
    }

    public function index(Request $request){
        return $this->router->view('user/perfil/index', [
            'perfil' => true,
            'usuario' => $this->usuario
        ]);
    }

    public function updateIcone(Request $request){
        $icone = $request->getBodyParams();
        
        if(isset($_FILES['icone'])){
            $icone = $_FILES['icone'];
        }

        $dir = "/user/icons";

        if(!$this->required($icone, ['name'])){
            return $this->router->view('user/perfil/index', [
                'erro' => 'Insira uma imagem para continuar',
                'perfil' => true,
                'usuario' => $this->usuario
            ]);
        }

        $update = $this->userRepository->updateIcone($this->usuario->id, $icone, $dir);

        if(is_null($update)){
            return $this->router->view('user/perfil/index', [
                'erro' => 'Não foi possível atualizar imagem de perfil',
                'perfil' => true,
                'usuario' => $this->usuario
            ]);
        }

        $_SESSION['user'] = $this->userRepository->findById($this->usuario->id);

        return $this->router->redirect('perfil');
    }

    public function updateDados(Request $request){
        $data = $request->getBodyParams();

        if(!$this->required($data, ['nome', 'email', 'cpf'])){
            return $this->router->view('user/perfil/index', [
                'perfil' => false,
                'usuario' => $this->usuario,
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        if(!$this->min($data['cpf'], 11)){
            return $this->router->view('user/perfil/index', [
                'perfil' => true,
                'usuario' => $this->usuario,
                'erro' => 'CPF deve conter ao menos 11 dígitos'
            ]);
        }

        if(!$this->email($data['email'])){
            return $this->router->view('user/perfil/index', [
                'perfil' => true,
                'usuario' => $this->usuario,
                'erro' => 'Email inválido'
            ]);
        }

        $update = $this->userRepository->update($data, $this->usuario->id);

        if(is_null($update)){
            return $this->router->view('user/perfil/index', [
                'erro' => 'Não foi possível editar seus dados',
                'perfil' => true,
                'usuario' => $this->usuario
            ]);
        }

        unset($update->senha);

        $_SESSION['user'] = $update;

        return $this->router->redirect('perfil');
    }

    public function updateSenha(Request $request){
        $data = $request->getBodyParams();

        if(!$this->required($data, ['senha'])){
            return $this->router->view('user/perfil/index', [
                'perfil' => true,
                'usuario' => $this->usuario,
                'erro' => 'Digite uma senha para atualizá-la'
            ]);
        }

        if(!$this->min($data['senha'], 8)){
            return $this->router->view('user/perfil/index', [
                'perfil' => true,
                'usuario' => $this->usuario,
                'erro' => 'Sua senha deve conter ao menos 8 dígitos'
            ]);
        }

        $update = $this->userRepository->updateSenha($data, $this->usuario->id);

        if(is_null($update)){
            return $this->router->view('user/perfil/index', [
                'erro' => 'Não foi possível editar sua senha',
                'perfil' => true,
                'usuario' => $this->usuario
            ]);
        }

        return $this->router->redirect('perfil');
    }

    public function destroy(Request $request){
        $delete = $this->userRepository->delete($this->usuario->id);

        if(!$delete){
            return $this->router->view('user/perfil/index', [
                'erro' => 'Não foi possível excluir sua conta'
            ]);
        }

        return $this->router->redirect('logout');
    }

}