<?php

namespace App\Controllers\OS;

use App\Request\Request;
use App\Controllers\Traits\GeneratePdf;
use App\Controllers\Traits\Validator;
use App\Controllers\Controller;
use App\Repositories\OS\OSRepository;
use App\Repositories\OS\OSServicoRepository;
use App\Repositories\Servico\ServicoRepository;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\Produto\ProdutoServicoRepository;
use App\Repositories\Cliente\ClienteRepository;
use App\Repositories\User\UserRepository;

class OSController extends Controller {

    protected $osRepository;
    protected $osServicoRepository;
    protected $servicoRepository;
    protected $produtoRepository;
    protected $produtoServicoRepository;
    protected $clienteRepository;
    protected $userRepository;

    use GeneratePdf;
    use Validator;

    public function __construct(){
        parent::__construct();
        $this->osRepository = new OSRepository();
        $this->osServicoRepository = new OSServicoRepository();
        $this->servicoRepository = new ServicoRepository();
        $this->produtoRepository = new ProdutoRepository();
        $this->produtoServicoRepository = new ProdutoServicoRepository();
        $this->clienteRepository = new ClienteRepository();
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request){
        if(!userPermission('visualizar os')){
            return $this->router->redirect('');
        }

        $params = $request->getQueryParams();

        $os = $this->osRepository->all($params);

        return $this->router->view('os/index', [
            'all_os' => $os
        ]);
    }

    public function create(Request $request){
        if(!userPermission('cadastrar os')){
            return $this->router->redirect('');
        }

        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        return $this->router->view('os/create', [
            'cadastro' => true,
            'clientes' => $clientes
        ]);
    }

    public function store(Request $request){
        if(!userPermission('cadastrar os')){
            return $this->router->redirect('');
        }

        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        $data = $request->getBodyParams();

        if(!$this->required($data, ['cliente'])){
            return $this->router->view('os/create', [
                'erro' => 'Selecione um cliente para continuar',
                'cadastro' => true,
                'clientes' => $clientes
            ]);
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
        if(!userPermission('editar os')){
            return $this->router->redirect('');
        }

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
        if(!userPermission('editar os')){
            return $this->router->redirect('');
        }

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

        $all_products = $this->produtoRepository->all();

        $all_services = $this->servicoRepository->all();

        $subtractProduct = $this->produtoRepository->verifyProductServiceQuantity($all_products, $all_services, $osServicos);

        return $this->router->redirect('os'); 
    }

    public function cancel(Request $request, $uuid){
        if(!userPermission('deletar os')){
            return $this->router->redirect('');
        }

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

    public function generatePdf(Request $request, $uuid){
        $os = $this->osRepository->findByUuid($uuid);
        if(!$os){
            return $this->router->redirect('os');
        }

        $cliente = $this->clienteRepository->findById($os->clientes_id);
        if(!$cliente){
            return $this->router->redirect('os');
        }

        $services = $this->osServicoRepository->allServicesInOS($os->id);

        $pdf = $this->generateOs($cliente, $os, $services);

        if(!$pdf){
            return $this->router->redirect('');
        }

        return $this->router->redirect('os');
    }

}