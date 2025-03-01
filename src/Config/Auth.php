<?php

namespace App\Config;

use App\Repositories\Permissao\PermissaoUserRepository;

class Auth {

    protected $permissaoUserRepository;

    public function __construct(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        $this->permissaoUserRepository = new PermissaoUserRepository();
    }

    public function login($user){
        if(is_null($user)){
            return false;
        }

        $_SESSION['user'] = $user;

        $permissoes = $this->permissaoUserRepository->allUserPermissions($_SESSION['user']->id);
        $_SESSION['permissoes'] = $permissoes;

        return true;
    }

    public function check(){
        if(isset($_SESSION['user'])){
            return true;
        }

        return false;
    }

    public function logout(){
        unset($_SESSION['user']);
        unset($_SESSION['permissoes']);
        session_destroy();
    }

    public function user(){
        return $_SESSION['user'] ?? null;
    }
}