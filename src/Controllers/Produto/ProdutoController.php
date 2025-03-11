<?php

namespace App\Controllers\Produto;

use App\Request\Request;
use App\Controllers\Traits\Validator;
use App\Controllers\Controller;
use App\Repositories\Produto\ProdutoRepository;

class ProdutoController extends Controller {

    public $produtoRepository;

    use Validator;

    public function __construct(){
        parent::__construct();
        $this->produtoRepository = new ProdutoRepository();
    }

    public function index(Request $request){
        if(!userPermission('visualizar produtos')){
            return $this->router->redirect('');
        }

        $params = $request->getQueryParams();

        $produtos = $this->produtoRepository->all($params);

        return $this->router->view('produto/index', [
            'produtos' => $produtos
        ]);
    }

    public function create(Request $request){
        if(!userPermission('cadastrar produtos')){
            return $this->router->redirect('');
        }

        return $this->router->view('produto/create', []);
    }

    public function store(Request $request){
        if(!userPermission('cadastrar produtos')){
            return $this->router->redirect('');
        }

        $data = $request->getBodyParams();

        if(!$this->required($data, ['nome', 'codigo', 'preco'])){
            return $this->router->view('produto/create', [
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $create = $this->produtoRepository->create($data);

        if(is_null($create)){
            return $this->router->view('produto/create', [
                'erro' => 'Não foi possível criar o produto'
            ]);
        }

        return $this->router->redirect('produtos');
    }

    public function edit(Request $request, $uuid){
        if(!userPermission('editar produtos')){
            return $this->router->redirect('');
        }

        $produto = $this->produtoRepository->findByUuid($uuid);

        if(!$produto){
            return $this->router->redirect('produtos');
        }

        return $this->router->view('produto/edit', [
            'produto' => $produto
        ]);
    }

    public function update(Request $request, $uuid){
        if(!userPermission('editar produtos')){
            return $this->router->redirect('');
        }

        $produto = $this->produtoRepository->findByUuid($uuid);

        if(!$produto){
            return $this->router->redirect('produtos');
        }

        $data = $request->getBodyParams();

        if(!$this->required($data, ['nome', 'codigo', 'preco'])){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $update = $this->produtoRepository->update($data, $produto->id);

        if(is_null($update)){
            return $this->router->view('produto/edit', [
                'produto' => $produto,
                'erro' => 'Não foi possível editar o produto'
            ]);
        }

        return $this->router->redirect('produtos');
    }

    public function destroy(Request $request, $uuid){
        if(!userPermission('deletar produtos')){
            return $this->router->redirect('');
        }

        $produto = $this->produtoRepository->findByUuid($uuid);

        if(!$produto){
            return $this->router->redirect('produtos');
        }

        $delete = $this->produtoRepository->delete($produto->id);

        if(!$delete){
            return $this->router->view('produto/edit', [
                'erro' => 'Não foi possível deletar o produto'
            ]);
        }

        return $this->router->redirect('produtos');
    }

}