<?php

namespace App\Controllers\Permissao;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Permissao\PermissaoUserRepository;
use App\Repositories\Permissao\PermissaoRepository;
use App\Repositories\User\UserRepository;

class PermissaoUserController extends Controller {

    protected $permissaoUserRepository;
    protected $permissaoRepository;
    protected $userRepository;

    public function __construct(){
        parent::__construct();
        $this->permissaoUserRepository = new PermissaoUserRepository();
        $this->permissaoRepository = new PermissaoRepository();
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request, $usuario_uuid){
        $usuario = $this->userRepository->findByUuid($usuario_uuid);

        if(!$usuario){
            return $this->router->redirect('');
        }

        $permissoes = $this->permissaoRepository->all(['ativo' => 1]);

        $permissaoUsuario = $this
            ->permissaoUserRepository
            ->allUserPermissions($usuario->id);

        return $this->router->view('permissao/permissao_user/index', [
            'usuario' => $usuario,
            'permissoes' => $permissoes,
            'permissao_user' => $permissaoUsuario
        ]);
    }

    public function create(Request $request, $usuario_uuid){
        $usuario = $this->userRepository->findByUuid($usuario_uuid);

        if(!$usuario){
            return $this->router->redirect('');
        }

        $data = $request->getBodyParams();

        $permissao = $this->permissaoRepository->findByUuid($data['permissao']);

        if(!$permissao){
            return $this->router->redirect('');
        }

        $linkPermissaoUser = $this
            ->permissaoUserRepository
            ->linkUserPermission($usuario->id, $permissao->id);

        if(is_null($linkPermissaoUser)){
            return $this->router->redirect('usuarios');
        }

        return $this
            ->router
            ->redirect('usuarios/'.$usuario_uuid.'/permissoes');

    }

    public function destroy(Request $request, $usuario_uuid, $permissao_uuid){
        $usuario = $this->userRepository->findByUuid($usuario_uuid);

        if(!$usuario){
            return $this->router->redirect('');
        }

        $permissao = $this->permissaoUserRepository->findByUuid($permissao_uuid);

        if(!$permissao){
            return $this->router->redirect('');
        }

        $unlinkPermissaoUser = $this
            ->permissaoUserRepository
            ->unlinkUserPermission($usuario->id, $permissao->permissoes_id);

        if(is_null($unlinkPermissaoUser)){
            return $this->router->redirect('usuarios');
        }

        $_SESSION['permissoes'] = $this
                ->permissaoUserRepository
                ->allUserPermissions($usuario->id);

        return $this
            ->router
            ->redirect('usuarios/'.$usuario->uuid.'/permissoes');
    }

}