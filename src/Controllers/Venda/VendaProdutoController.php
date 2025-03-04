<?php

namespace App\Controllers\Venda;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Venda\VendaProdutoRepository;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Cliente\ClienteRepository;

class VendaProdutoController extends Controller {

    public $vendaProdutoRepository;
    public $vendaRepository;
    public $produtoRepository;
    public $usuarioRepository;
    public $clienteRepository;

    public function __construct(){
        parent::__construct();
        $this->vendaProdutoRepository = new VendaProdutoRepository();
        $this->vendaRepository = new VendaRepository();
        $this->produtoRepository = new ProdutoRepository();
        $this->usuarioRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
    }

    public function linkProducts(Request $request, $uuid){
        $params = $request->getQueryParams();

        $params = array_merge($params, ['ativo' => 1]);

        $venda = $this->vendaRepository->findByUuid($uuid);
        $cliente = $this->clienteRepository->findById($venda->clientes_id);
        $produtos = $this->produtoRepository->all($params);
        $vendaProdutos = $this->vendaProdutoRepository->allProductsInSale($venda->id);

        $desconto = $venda->desconto;
        $total = 0;

        foreach($vendaProdutos as $produto){
            $total += $produto->preco;
        }

        if($venda->desconto > 0){
            $desconto = ($venda->desconto * $total) / 100;
            $total -= $desconto;
        }

        return $this->router->view('venda/venda_produto/index', [
            'venda' => $venda,
            'produtos' => $produtos,
            'vendaProdutos' => $vendaProdutos,
            'cliente' => $cliente,
            'total' => $total,
            'params' => $params
        ]);
    }

}