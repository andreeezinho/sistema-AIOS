<?php

namespace App\Repositories\Venda;

use App\Config\Database;
use App\Repositories\Traits\Find;
use App\Models\Venda\VendaProduto;

class VendaProdutoRepository {

    const CLASS_NAME = VendaProduto::class;
    const TABLE = 'venda_produto';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new VendaProduto();
    }

    public function allProductsInSale($venda_id){
        $sql = "SELECT vp.*,
			v.id as venda,
            p.nome as nome, p.codigo as codigo, p.preco, p.uuid as uuidProduto
            FROM " . self::TABLE . " vp
            JOIN vendas v
                ON vendas_id = v.id
            JOIN produtos p
                ON produtos_id = p.id
            WHERE v.id = :venda_id
            ORDER BY vp.created_at ASC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':venda_id' => $venda_id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

}