<?php

namespace App\Models\OS;

use App\Models\Traits\Uuid;
 
class OSServico {

    use Uuid;

    public $id;
    public $uuid;
    public $os_id;
    public $os;
    public $servicos_id;
    public $nome;
    public $descricao;
    public $preco;
    public $uuidServico;
    public $created_at;
    public $updated_at;

    public function create(int $os_id, int $servicos_id){
        $osServico = new OS();
        $os->id = $data['id'] ?? null;
        $os->uuid = $data['uuid'] ?? $this->generateUUID();
        $os->os_id = $os_id ?? null;
        $os->servicos_id = $servicos_id ?? null;
        $os->created_at = $data['created_at'] ?? null;
        $os->updated_at = $data['updated_at'] ?? null;
        return $osServico;
    }

} 