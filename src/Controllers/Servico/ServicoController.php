<?php

namespace App\Controllers\Servico;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Servico\ServicoRepository;

class ServicoController extends Controller {

    public $servicoRepository;

    public function __construct(){
        parent::__construct();
        $this->servicoRepository = new ServicoRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $servicos = $this->servicoRepository->all($params);

        return $this->router->view('servico/index', [
            'servicos' => $servicos
        ]);
    }

    public function create(Request $request){
        return $this->router->view('servico/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        $create = $this->servicoRepository->create($data);

        if(is_null($create)){
            return $this->router->view('servico/create', [
                'erro' => 'Não foi possível criar o serviço'
            ]);
        }

        return $this->router->redirect('servicos');
    }

    public function edit(Request $request, $uuid){
        $servico = $this->servicoRepository->findByUuid($uuid);

        if(!$servico){
            return $this->router->redirect('servicos');
        }

        return $this->router->view('servico/edit', [
            'servico' => $servico
        ]);
    }

    public function update(Request $request, $uuid){
        $servico = $this->servicoRepository->findByUuid($uuid);

        if(!$servico){
            return $this->router->redirect('servicos');
        }
        
        $data = $request->getBodyParams();

        $update = $this->servicoRepository->update($data, $servico->id);

        if(is_null($update)){
            return $this->router->view('servico/edit', [
                'erro' => 'Não foi possível criar o serviço'
            ]);
        }

        return $this->router->redirect('servicos');
    }

    public function destroy(Request $request, $uuid){
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