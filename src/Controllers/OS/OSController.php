<?php

namespace App\Controllers\OS;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\OS\OSRepository;
use App\Repositories\OS\OSServicoRepository;
use App\Repositories\Cliente\ClienteRepository;
use App\Repositories\User\UserRepository;

class OSController extends Controller {

    protected $osRepository;
    protected $osServicoRepository;
    protected $clienteRepository;
    protected $userRepository;

    public function __construct(){
        parent::__construct();
        $this->osRepository = new OSRepository();
        $this->osServicoRepository = new OSServicoRepository();
        $this->clienteRepository = new ClienteRepository();
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $os = $this->osRepository->all($params);

        return $this->router->view('os/index', [
            'all_os' => $os
        ]);
    }

    public function create(Request $request){
        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        return $this->router->view('os/create', [
            'cadastro' => true,
            'clientes' => $clientes
        ]);
    }

    public function store(Request $request){
        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        $data = $request->getBodyParams();

        if(!is_null($data['situacao'])){
            $data['situacao'] = 'em andamento';
        }

        $cliente = $this->clienteRepository->findByUuid($data['cliente']);

        $create = $this->osRepository->create($data, $_SESSION['user']->id, $cliente->id);

        if(is_null($create)){
            return $this->router->view('os/create', [
                'erro' => 'Não foi possível cadastrar a O.S',
                'cadastro' => true,
                'clientes' => $clientes
            ]);
        }

        return $this->router->redirect('os/'. $create->uuid . '/servicos');
    }

    public function update(Request $request, $uuid){
        $os = $this->osRepository->findByUuid($uuid);
        if(!$os){
            return $this->router->redirect('os');
        }

        $data = $request->getBodyParams();

        $update = $this->osRepository->update($data, $os->usuarios_id, $os->clientes_id, $os->id);

        if(is_null($update)){
            return $this->router->redirect('os');
        }

        return $this->router->redirect('os/'. $update->uuid . '/servicos');
    }

    public function finish(Request $request, $uuid){
        $os = $this->osRepository->findByUuid($uuid);
        if(!$os){
            return $this->router->redirect('os');
        }

        $osServicos = $this->osServicoRepository->allServicesInOS($os->id);

        $total = priceWithDiscount($osServicos, $os->desconto);

        $finish = $this->osRepository->finish($total, $os->id);

        if(is_null($finish)){
            return $this->router->redirect('os/'. $os->uuid . '/servicos');
        }

        return $this->router->redirect('os'); 
    }

    public function cancel(Request $request, $uuid){
        $params = $request->getQueryParams();

        $all_os = $this->osRepository->all($params);

        $os = $this->osRepository->findByUuid($uuid);
        if(!$os){
            return $this->router->redirect('os');
        }

        $cancel = $this->osRepository->cancel($os->id);

        if(is_null($cancel)){
            return $this->router->view('os/index', [
                'erro' => 'Não foi possível cancelar a O.S',
                'all_os' => $all_os
            ]);
        }

        return $this->router->redirect('os'); 
    }

}