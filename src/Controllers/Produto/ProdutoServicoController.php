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

    public function linkProductsInService(Request $request, $servico_uuid, $produto_uuid){
        $servico = $this->servicoRepository->findByUuid($servico_uuid);
        if(!$servico){
            return $this->router->redirect('servicos');
        }

        $produto = $this->produtoRepository->findByUuid($produto_uuid);
        if(!$produto){
            return $this->router->redirect('servicos');
        }

        $linkProductInService = $this
            ->produtoServicoRepository
            ->linkProduct($servico->id, $produto->id);

        if(is_null($linkProductInService)){
            return $this->router->redirect('servicos');
        }

        return $this->router->redirect('servicos/'. $servico->uuid .'/produtos');
    }

    public function unlinkProductsInService(Request $request, $servico_uuid, $produto_uuid, $uuid){
        $servico = $this->servicoRepository->findByUuid($servico_uuid);
        if(!$servico){
            return $this->router->redirect('servicos');
        }

        $produto = $this->produtoRepository->findByUuid($produto_uuid);
        if(!$produto){
            return $this->router->redirect('servicos');
        }

        $produtoServico = $this->produtoServicoRepository->findByUuid($uuid);

        $unlinkProductInService = $this
            ->produtoServicoRepository
            ->unlinkProduct($servico->id, $produto->id, $produtoServico->id);

        if(!$unlinkProductInService){
            return $this->router->redirect('servicos');
        }

        return $this->router->redirect('servicos/'. $servico->uuid .'/produtos');
    }

    public function updatePrice(Request $request, $uuid){
        $servico = $this->servicoRepository->findByUuid($uuid);
        if(!$servico){
            return $this->router->redirect('servicos');
        }

        $produtoServico = $this->produtoServicoRepository->allProductsInService($servico->id);

        $total = priceWithDiscount($produtoServico, 0);

        $total += $servico->preco;

        $updatePrice = $this->servicoRepository->updatePrice($total, $servico->id);

        if(is_null($updatePrice)){
            return $this->router->redirect('servicos/'. $uuid .'/produtos');
        }

        return $this->router->redirect('servicos');
    }

}