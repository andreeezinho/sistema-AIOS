<?php

namespace App\Models\Servico;

use App\Models\Traits\Uuid;

class Servico {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $descricao;
    public $preco;
    public $created_at;
    public $updated_at;

    public function create(array $data) : Servico {
        $servico = new Servico();
        $servico->id = $data['id'] ?? null;
        $servico->uuid = $data['uuid'] ?? $this->generateUUID();
        $servico->nome = $data['nome'] ?? null;
        $servico->descricao = $data['descricao'] ?? null;
        $servico->preco = $data['preco'] ?? null;
        $servico->ativo = $data['ativo'] ?? 1;
        $servico->created_at = $data['created_at'] ?? null;
        $servico->updated_at = $data['updated_at'] ?? null;
        return $servico;
    }
}