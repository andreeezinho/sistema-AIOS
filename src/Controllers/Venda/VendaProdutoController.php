<?php

namespace App\Controllers\Venda;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Cliente\ClienteRepository;

class VendaProdutoController extends Controller {

    public $vendaRepository;
    public $produtoRepository;
    public $usuarioRepository;
    public $clienteRepository;

    public function __construct(){
        parent::__construct();
        $this->vendaRepository = new VendaRepository();
        $this->produtoRepository = new ProdutoRepository();
        $this->usuarioRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
    }

    public function linkProducts(Request $request, $uuid){
        $params = $request->getQueryParams();

        $params = array_merge($params, ['ativo' => 1]);

        $venda = $this->vendaRepository->findByUuid($uuid);
        $produtos = $this->produtoRepository->all($params);

        return $this->router->view('venda/venda_produto/index', [
            'venda' => $venda,
            'produtos' => $produtos,
            'params' => $params
        ]);
    }

}