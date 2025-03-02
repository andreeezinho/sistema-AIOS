<?php

namespace App\Models\Cliente;

use App\Models\Traits\Uuid;

class Cliente {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $email;
    public $documento;
    public $telefone;
    public $endereco;
    public $ativo;
    public $created_at;
    public $updated_at;

    public function create(array $data) : Cliente {
        $cliente = new Cliente();
        $cliente->id = $data['id'] ?? null;
        $cliente->uuid = $data['uuid'] ?? $this->generateUUID();
        $cliente->nome = $data['nome'] ?? null;
        $cliente->email = $data['email'] ?? null;
        $cliente->email = $data['email'] ?? null;
        $cliente->documento = $data['documento'] ?? null;
        $cliente->telefone = $data['telefone'] ?? null;
        $cliente->endereco = $data['endereco'] ?? null;
        $cliente->ativo = ($data['ativo'] == "") ? 1 : $data['ativo'];
        $cliente->created_at = $data['created_at'] ?? null;
        $cliente->updated_at = $data['updated_at'] ?? null;
        return $cliente;
    }
}