<?php

namespace App\Models\OS;

use App\Models\Traits\Uuid;
 
class OS {

    use Uuid;

    public $id;
    public $uuid;
    public $clientes_id;
    public $cliente;
    public $documento;
    public $dispositivo;
    public $desconto;
    public $total;
    public $situacao;
    public $usuarios_id;
    public $usuario;
    public $cpf;
    public $created_at;
    public $updated_at;

    public function create(array $data, int $clientes_id, int $usuarios_id){
        $os = new OS();
        $os->id = $data['id'] ?? null;
        $os->uuid = $data['uuid'] ?? $this->generateUUID();
        $os->clientes_id = $clientes_id ?? null;
        $os->dispositivo = $data['dispositivo'] ?? null;
        $os->desconto = $data['desconto'] ?? null;
        $os->total = $data['total'] ?? null;
        $os->situacao = $data['situacao'] ?? null;
        $os->usuarios_id = $usuarios_id ?? null;
        $os->created_at = $data['created_at'] ?? null;
        $os->updated_at = $data['updated_at'] ?? null;
        return $os;
    }

} 