<?php

namespace App\Models\Produto;

use App\Models\Traits\Uuid;

class Produto {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $codigo;
    public $preco;
    public $estoque;
    public $ativo;
    public $created_at;
    public $updated_at;

    public function create(array $data) : Produto {
        $produto = new Produto();
        $produto->id = $data['id'] ?? null;
        $produto->uuid = $data['uuid'] ?? $this->generateUUID();
        $produto->nome = $data['nome'] ?? null;
        $produto->codigo = $data['codigo'] ?? null;
        $produto->preco = $data['preco'] ?? null;
        $produto->estoque = $data['estoque'] ?? null;
        $produto->ativo = ($data['ativo'] == "") ? 1 : $data['ativo'];
        $produto->created_at = $data['created_at'] ?? null;
        $produto->updated_at = $data['updated_at'] ?? null;
        return $produto;
    }

}