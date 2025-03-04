<?php

namespace App\Models\Venda;

use App\Models\Traits\Uuid;

class VendaProduto {

    use Uuid;

    public $id;
    public $uuid;
    public $quantidade;
    public $produtos_id;
    public $vendas_id;
    public $venda;
    public $nome;
    public $codigo;
    public $preco;
    public $uuidProduto;
    public $created_at;
    public $updated_at;

    public function create(
        array $data
    ) : Venda {
        $venda = new Venda();
        $venda->id = $data['id'] ?? null;
        $venda->uuid = $data['uuid'] ?? $this->generateUUID();
        $venda->created_at = $data['created_at'] ?? null;
        $venda->updated_at = $data['updated_at'] ?? null;
        return $venda;
    }

}