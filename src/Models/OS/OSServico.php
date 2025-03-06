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

    public function create(array $data = []){
        $osServico = new OS();
        $osServico->id = $data['id'] ?? null;
        $osServico->uuid = $data['uuid'] ?? $this->generateUUID();
        $osServico->created_at = $data['created_at'] ?? null;
        $osServico->updated_at = $data['updated_at'] ?? null;
        return $osServico;
    }

} 