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

}