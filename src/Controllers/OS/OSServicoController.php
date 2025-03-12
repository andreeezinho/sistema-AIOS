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
        if(!userPermission('visualizar os')){
            return $this->router->redirect('');
        }

        $params = $request->getQueryParams();

        $params = array_merge($params, ['ativo' => 1]);

        $os = $this->osRepository->findByUuid($uuid);
        if(!$os){
            return $this->router->redirect('os');
        }

        $servicos = $this->servicoRepository->all($params);
        $cliente = $this->clienteRepository->findById($os->clientes_id);
        $usuario = $this->usuarioRepository->findById($os->usuarios_id);
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

    public function linkServiceInOs(Request $request, $os_uuid, $servico_uuid){
        if(!userPermission('editar os')){
            return $this->router->redirect('');
        }

        $os = $this->osRepository->findByUuid($os_uuid);
        if(!$os){
            return $this->router->redirect('os');
        }

        $servico = $this->servicoRepository->findByUuid($servico_uuid);
        if(!$servico){
            return $this->router->redirect('os');
        }

        $linkServiceInOs = $this
            ->osServicoRepository
            ->linkService($os->id, $servico->id);

        if(is_null($linkServiceInOs)){
            return $this->router->redirect('os');
        }

        return $this->router->redirect('os/'. $os->uuid .'/servicos');
    }

    public function unlinkServiceInOs(Request $request, $os_uuid, $servico_uuid, $uuid){
        if(!userPermission('deletar os')){
            return $this->router->redirect('');
        }

        $os = $this->osRepository->findByUuid($os_uuid);
        if(!$os){
            return $this->router->redirect('os');
        }

        $servico = $this->servicoRepository->findByUuid($servico_uuid);
        if(!$servico){
            return $this->router->redirect('os');
        }

        $osServico = $this->osServicoRepository->findByUuid($uuid);
        if(!$osServico){
            return $this->router->redirect('os');
        }

        $unlinkServiceInOs = $this
            ->osServicoRepository
            ->unlinkService($os->id, $servico->id, $osServico->id);

        if(!$unlinkServiceInOs){
            return $this->router->redirect('os');
        }

        return $this->router->redirect('os/'. $os->uuid .'/servicos');
    }

}