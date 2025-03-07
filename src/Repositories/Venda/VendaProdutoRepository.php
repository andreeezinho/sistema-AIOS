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

    public function linkProduct(int $venda_id, int $produto_id){
        $data = ['quantidade' => 1];
        $vendaProduto = $this->model->create($data);
        try{
            
            $sql = "INSERT INTO ". self::TABLE . "
                SET 
                    uuid = :uuid,
                    vendas_id = :vendas_id,
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $vendaProduto->uuid,
                ':vendas_id' => $venda_id,
                ':produtos_id' => $produto_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($vendaProduto->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function unlinkProduct(int $venda_id, int $produto_id, int $id){
        $sql = "DELETE FROM " . self::TABLE . "
            WHERE
                id = :id
            AND
                vendas_id = :vendas_id
            AND
                produtos_id = :produtos_id
        ";

        $stmt = $this->conn->prepare($sql);

        $delete = $stmt->execute([
            ':id' => $id,
            ':vendas_id' => $venda_id,
            ':produtos_id' => $produto_id
        ]);

        return $delete;
    }

}