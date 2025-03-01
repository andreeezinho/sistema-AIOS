<?php

namespace App\Controllers\Permissao;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Permissao\PermissaoRepository;
use App\Repositories\User\UserRepository;

class PermissaoController extends Controller {

    protected $permissaoRepository;
    protected $userRepository;

    public function __construct(){
        parent::__construct();
        $this->permissaoRepository = new PermissaoRepository();
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $permissoes = $this->permissaoRepository->all($params);

        return $this->router->view('permissao/index', [
            'permissoes' => $permissoes
        ]);
    }

    public function create(Request $request){
        return $this->router->view('permissao/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();
        

        $create = $this->permissaoRepository->create($data);

        if(is_null($create)){
            return $this->router->view('permissao/create', [
                'erro' => 'Não foi possível criar a permissão'
            ]);
        }

        return $this->router->redirect('permissoes');
    }

    public function edit(Request $resquest, $uuid){
        $permissao = $this->permissaoRepository->findByUuid($uuid);

        if(!$permissao){
            return $this->router->redirect('');
        }

        return $this->router->view('permissao/edit', [
            'permissao' => $permissao
        ]);
    }

    public function update(Request $request, $uuid){
        $permissao = $this->permissaoRepository->findByUuid($uuid);

        if(!$permissao){
            return $this->router->redirect('');
        }

        $data = $request->getBodyParams();

        if($data['nome'] == "" || $data['tipo'] == ""){
            return $this->router->view('permissao/edit', [
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $update = $this->permissaoRepository->update($data, $permissao->id);

        if(is_null($update)){
            return $this->router->view('permissao/index', [
                'erro' => 'Não foi possível editar permissão'
            ]);
        }

        return $this->router->redirect('permissoes');
    }

    public function destroy(Request $request, $uuid){
        $permissao = $this->permissaoRepository->findByUuid($uuid);

        if(!$permissao){
            return $this->router->redirect('permissoes');
        }

        $delete = $this->permissaoRepository->delete($permissao->id);

        if(!$delete){
            return $this->router->redirect('permissoes');
        }

        return $this->router->redirect('permissoes');
    }

}