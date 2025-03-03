<?php

namespace App\Models\Venda;

use App\Models\Traits\Uuid;

class Venda {

    use Uuid;

    public $id;
    public $uuid;
    public $desconto;
    public $total;
    public $situacao;
    public $clientes_id;
    public $cliente;
    public $documento;
    public $usuarios_id;
    public $usuario;
    public $cpf;
    public $created_at;
    public $updated_at;

    public function create(
        array $data, int $usuario_id, int $cliente_id
    ) : Venda {
        $venda = new Venda();
        $venda->id = $data['id'] ?? null;
        $venda->uuid = $data['uuid'] ?? $this->generateUUID();
        $venda->desconto = $data['desconto'] ?? 0;
        $venda->total = $data['total'] ?? null;
        $venda->situacao = ($data['situacao'] == "") ? "em andamento" : $data['situacao'];
        $venda->usuarios_id = $usuario_id ?? null;
        $venda->clientes_id = $cliente_id;
        $venda->created_at = $data['created_at'] ?? null;
        $venda->updated = $data['updated'] ?? null;
        return $venda;
    }

}