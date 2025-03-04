<?php

namespace App\Controllers\Produto;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\Produto\ProdutoServicoRepository;
use App\Repositories\Servico\ServicoRepository;

class ProdutoServicoController extends Controller {

    public $produtoRepository;
    public $produtoServicoRepository;
    public $servicoRepository;

    public function __construct(){
        parent::__construct();
        $this->produtoRepository = new ProdutoRepository();
        $this->produtoServicoRepository = new ProdutoServicoRepository();
        $this->servicoRepository = new ServicoRepository();
    }

    public function linkProducts(Request $request, $uuid){
        $params = $request->getQueryParams();

        $servico = $this->servicoRepository->findByUuid($uuid);
        $produtos = $this->produtoRepository->all($params);
        $produtoServico = $this->produtoServicoRepository->allProductsInService($servico->id);

        $total = priceWithDiscount($produtoServico, 0);

        return $this->router->view('produto/produto_servico/index', [
            'servico' => $servico,
            'produtos' => $produtos,
            'produtoServicos' => $produtoServico,
            'total' => $total,
            'params' => $params
        ]);
    }

}