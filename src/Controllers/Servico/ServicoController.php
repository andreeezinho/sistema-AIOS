<?php

namespace App\Controllers\Servico;

use App\Request\Request;
use App\Controllers\Traits\Validator;
use App\Controllers\Controller;
use App\Repositories\Servico\ServicoRepository;

class ServicoController extends Controller {

    public $servicoRepository;

    use Validator;

    public function __construct(){
        parent::__construct();
        $this->servicoRepository = new ServicoRepository();
    }

    public function index(Request $request){
        if(!userPermission('visualizar servicos')){
            return $this->router->redirect('');
        }

        $params = $request->getQueryParams();

        $servicos = $this->servicoRepository->all($params);

        return $this->router->view('servico/index', [
            'servicos' => $servicos
        ]);
    }

    public function create(Request $request){
        if(!userPermission('cadastrar servicos')){
            return $this->router->redirect('');
        }

        return $this->router->view('servico/create', []);
    }

    public function store(Request $request){
        if(!userPermission('cadastrar servicos')){
            return $this->router->redirect('');
        }

        $data = $request->getBodyParams();

        if(!$this->required($data, ['nome', 'preco'])){
            return $this->router->view('servico/create', [
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $create = $this->servicoRepository->create($data);

        if(is_null($create)){
            return $this->router->view('servico/create', [
                'erro' => 'Não foi possível criar o serviço'
            ]);
        }

        return $this->router->redirect('servicos');
    }

    public function edit(Request $request, $uuid){
        if(!userPermission('editar servicos')){
            return $this->router->redirect('');
        }

        $servico = $this->servicoRepository->findByUuid($uuid);

        if(!$servico){
            return $this->router->redirect('servicos');
        }

        return $this->router->view('servico/edit', [
            'servico' => $servico
        ]);
    }

    public function update(Request $request, $uuid){
        if(!userPermission('editar servicos')){
            return $this->router->redirect('');
        }

        $servico = $this->servicoRepository->findByUuid($uuid);

        if(!$servico){
            return $this->router->redirect('servicos');
        }
        
        $data = $request->getBodyParams();

        if(!$this->required($data, ['nome', 'preco'])){
            return $this->router->view('servico/edit', [
                'servico' => $servico,
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $update = $this->servicoRepository->update($data, $servico->id);

        if(is_null($update)){
            return $this->router->view('servico/edit', [
                'servico' => $servico,
                'erro' => 'Não foi possível criar o serviço'
            ]);
        }

        return $this->router->redirect('servicos');
    }

    public function destroy(Request $request, $uuid){
        if(!userPermission('deletar servicos')){
            return $this->router->redirect('');
        }

        $servico = $this->servicoRepository->findByUuid($uuid);

        if(!$servico){
            return $this->router->redirect('servicos');
        }

        $delete = $this->servicoRepository->delete($servico->id);

        if(!$delete){
            return $this->router->view('servico/index', [
                'erro' => 'Não foi possível deletar o serviço'
            ]);
        }

        return $this->router->redirect('servicos');
    }

}