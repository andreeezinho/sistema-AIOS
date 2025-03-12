<?php

namespace App\Models\Produto;

use App\Models\Traits\Uuid;

class ProdutoServico { 

    use Uuid;

    public $id;
    public $uuid;
    public $produtos_id;
    public $nome;
    public $codigo;
    public $quantidade;
    public $preco;
    public $uuidProduto;
    public $servico;
    public $servicos_id;
    public $created_at;
    public $updated_at;

    public function create(int $produtos_id, int $servicos_id) : ProdutoServico {
        $produto_servico = new ProdutoServico;
        $produto_servico->id = $data['id'] ?? null;
        $produto_servico->uuid = $data['uuid'] ?? $this->generateUUID();
        $produto_servico->produtos_id = $produtos_id ?? null;
        $produto_servico->servicos_id = $servicos_id ?? null;
        $produto_servico->created_at = $data['created_at'] ?? null;
        $produto_servico->updated_at = $data['updated_at'] ?? null;
        return $produto_servico;
    }
    
}