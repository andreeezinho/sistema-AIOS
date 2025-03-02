<?php

namespace App\Controllers\Produto;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Produto\ProdutoRepository;

class ProdutoController extends Controller {

    public $produtoRepository;

    public function __construct(){
        parent::__construct();
        $this->produtoRepository = new ProdutoRepository();
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $produtos = $this->produtoRepository->all($params);

        return $this->router->view('produto/index', [
            'produtos' => $produtos
        ]);
    }

    public function create(Request $request){
        return $this->router->view('produto/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        $create = $this->produtoRepository->create($data);

        if(is_null($create)){
            return $this->router->view('produto/create', [
                'erro' => 'Não foi possível criar o produto'
            ]);
        }

        return $this->router->redirect('produtos');
    }

}