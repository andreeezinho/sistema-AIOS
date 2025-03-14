<?php

namespace App\Controllers\Venda;

use App\Request\Request;
use App\Controllers\Traits\GeneratePdf;
use App\Controllers\Traits\Validator;
use App\Controllers\Controller;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\Venda\VendaProdutoRepository;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Cliente\ClienteRepository;

class VendaController extends Controller {

    public $vendaRepository;
    public $vendaProdutoRepository;
    public $produtoRepository;
    public $usuarioRepository;
    public $clienteRepository;

    use GeneratePdf;
    use Validator;

    public function __construct(){
        parent::__construct();
        $this->vendaRepository = new VendaRepository();
        $this->vendaProdutoRepository = new VendaProdutoRepository();
        $this->produtoRepository = new ProdutoRepository();
        $this->usuarioRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
    }

    public function index(Request $request){
        if(!userPermission('visualizar vendas')){
            return $this->router->redirect('');
        }

        $params = $request->getQueryParams();
        
        $vendas = $this->vendaRepository->all($params);

        return $this->router->view('venda/index', [
            'vendas' => $vendas
        ]);
    }

    public function create(Request $request){
        if(!userPermission('cadastrar vendas')){
            return $this->router->redirect('');
        }
        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        return $this->router->view('venda/create', [
            'cadastro' => true,
            'clientes' => $clientes
        ]);
    }

    public function store(Request $request){
        if(!userPermission('cadastrar vendas')){
            return $this->router->redirect('');
        }

        $clientes = $this->clienteRepository->all(['ativo' => 1]);

        $data = $request->getBodyParams();

        if(!$this->required($data, ['cliente'])){
            return $this->router->view('venda/create', [
                'erro' => 'Insira um cliente para continuar',
                'cadastro' => true,
                'clientes' => $clientes
            ]);
        }

        $cliente = $this->clienteRepository->findByUuid($data['cliente']);

        if(!$cliente){
            return $this->router->redirect('');
        }

        $create = $this->vendaRepository->create($data, $_SESSION['user']->id, $cliente->id);

        if(is_null($create)){
            return $this->router->view('venda/create', [
                'erro' => 'Não foi possível cadastrar a venda',
                'cadastro' => true,
                'clientes' => $clientes
            ]);
        }

        return $this->router->redirect('vendas/'. $create->uuid . '/produtos');
    }

    public function update(Request $request, $uuid){
        if(!userPermission('editar vendas')){
            return $this->router->redirect('');
        }

        $venda = $this->vendaRepository->findByUuid($uuid);
        if(!$venda){
            return $this->router->redirect('vendas/'. $uuid .'/produtos');
        }

        $data = $request->getBodyParams();

        $update = $this
            ->vendaRepository
            ->update(
                $data, $venda->id, $venda->clientes_id, $venda->usuarios_id
            );

        if(is_null($update)){
            return $this->router->redirect('vendas/'. $uuid .'/produtos');
        }

        return $this->router->redirect('vendas/'. $uuid .'/produtos');
    }

    public function finish(Request $request, $uuid){
        if(!userPermission('editar vendas')){
            return $this->router->redirect('');
        }

        $venda = $this->vendaRepository->findByUuid($uuid);
        if(!$venda){
            return $this->router->redirect('vendas/'. $uuid .'/produtos');
        }

        $cliente = $this->clienteRepository->findById($venda->clientes_id);
        if(!$cliente){
            return $this->router->redirect('vendas/'. $uuid .'/produtos');
        }

        $vendaProdutos = $this->vendaProdutoRepository->allProductsInSale($venda->id);

        $total = priceWithDiscount($vendaProdutos, $venda->desconto);

        $finish = $this->vendaRepository->finish($total, $venda->id);

        if(is_null($finish)){
            return $this->router->redirect('vendas/'. $uuid .'/produtos');
        }

        $all_products = $this->produtoRepository->all();

        $subtractProduct = $this->produtoRepository->verifyProductQuantity($all_products, $vendaProdutos);

        if(!$subtractProduct){
            return $this->router->view('venda/venda_produto/index', [
                'venda' => $venda,
                'produtos' => $all_products,
                'vendaProdutos' => $vendaProdutos,
                'cliente' => $cliente,
                'total' => $total,
                'erro' => 'Quantidade acima do disponível no estoque do produto'
            ]);
        }

        return $this->router->redirect('vendas');
    }

    public function cancel(Request $request, $uuid){
        if(!userPermission('deletar vendas')){
            return $this->router->redirect('');
        }

        $params = $request->getQueryParams();

        $vendas = $this->vendaRepository->all($params);

        $venda = $this->vendaRepository->findByUuid($uuid);
        if(!$venda){
            return $this->router->redirect('vendas/'. $uuid .'/produtos');
        }

        $cancel = $this->vendaRepository->cancel($venda->id);

        if(is_null($cancel)){
            return $this->router->view('venda/index', [
                'erro' => 'Não foi possível cancelar a venda',
                'vendas' => $vendas
            ]);
        }

        return $this->router->redirect('vendas');
    }

    public function generatePdf(Request $request, $uuid){
        $venda = $this->vendaRepository->findByUuid($uuid);
        if(!$venda){
            return $this->router->redirect('vendas');
        }

        $cliente = $this->clienteRepository->findById($venda->clientes_id);
        if(!$cliente){
            return $this->router->redirect('vendas');
        }

        $produtos = $this->vendaProdutoRepository->allProductsInSale($venda->id);

        $pdf = $this->generateSale($cliente, $venda, $produtos);

        if(!$pdf){
            return $this->router->redirect('');
        }

        return $this->router->redirect('vendas');
    }

}