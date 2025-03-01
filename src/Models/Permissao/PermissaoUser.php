<?php

namespace App\Models\Permissao;

use App\Models\Traits\Uuid;


class PermissaoUser {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $permissoes_id;
    public $usuarios_id;
    public $created_at;
    public $updated_at;

    public function __construct(){}

    public function create(int $usuario_id, int $permissao_id) : PermissaoUser {
        $permissao_user = new PermissaoUser();
        $permissao_user->id = null;
        $permissao_user->uuid = $this->generateUUID();
        $permissao_user->nome = null;
        $permissao_user->permissoes_id = $permissao_id;
        $permissao_user->usuarios_id = $usuario_id;
        $permissao_user->created_at = null;
        $permissao_user->updated_at = null;
        return $permissao_user;
    }

}

