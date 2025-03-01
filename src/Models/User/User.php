<?php

namespace App\Models\User;

use App\Models\Traits\Uuid;

class User {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $email;
    public $cpf;
    public $telefone;
    public $senha;
    public $ativo;
    public $icone;
    public $created_at;
    public $updated_at;

    public function __construct(){}

    public function create(array $data) : User {
        $user = new User();
        $user->id = $data['id'] ?? null;
        $user->uuid = $data['uuid'] ?? $this->generateUUID();
        $user->nome = $data['nome'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->cpf = $data['cpf'] ?? null;
        $user->telefone = $data['telefone'] ?? null;
        $user->senha = password_hash($data['senha'], PASSWORD_BCRYPT);
        $user->ativo = ($data['ativo'] == "") ? 1 : $data['ativo'];
        $user->icone = ($data['icone'] == "") ? "default.png" : $data['icone'];
        $user->created_at = $data['created_at'] ?? null;
        $user->updated_at = $data['updated_at'] ?? null;
        return $user;
    }

    public function updateSenha(array $data) : User {
        $user = new User();
        $user->senha = password_hash($data['senha'], PASSWORD_BCRYPT);
        return $user;
    }

}