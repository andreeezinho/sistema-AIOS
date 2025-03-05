<?php

namespace App\Controllers\OS;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\OS\OSServicoRepository;
use App\Repositories\OS\OSRepository;
use App\Repositories\Servico\ServicoRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Cliente\ClienteRepository;

class OSServicoController extends Controller {

    protected $osServicoRepository;
    protected $osRepository;
    protected $servicoRepository;
    protected $usuarioRepository;
    protected $clienteRepository;

    public function __construct(){
        parent::__construct();
        $this->osServicoRepository = new OSServicoRepository();
        $this->osRepository = new OSRepository();
        $this->servicoRepository = new ServicoRepository();
        $this->usuarioRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
    }

    public function linkServices(Request $request, $uuid){
        $params = $request->getQueryParams();

        $params = array_merge($params, ['ativo' => 1]);

        $os = $this->osRepository->findByUuid($uuid);
        if(!$os){
            return $this->router->redirect('os');
        }

        $servicos = $this->servicoRepository->all($params);
        $cliente = $this->clienteRepository->findById($os->clientes_id);
        $usuario = $this->clienteRepository->findById($os->usuarios_id);
        $osServicos = $this->osServicoRepository->allServicesInOS($os->id);

        $total = priceWithDiscount($osServicos, $os->desconto);

        return $this->router->view('os/os_servico/index', [
            'os' => $os,
            'servicos' => $servicos,
            'cliente' => $cliente,
            'usuario' => $usuario,
            'osServicos' => $osServicos,
            'params' => $params,
            'total' => $total
        ]);
    }

}