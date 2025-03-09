<?php

namespace App\Repositories\Produto;

use App\Config\Database;
use App\Repositories\Traits\Find;
use App\Models\Produto\Produto;

class ProdutoRepository {

    const CLASS_NAME = Produto::class;
    const TABLE = 'produtos';

    use Find;

    public $model;
    public $conn;

    public function __construct(){
        $this->model = new Produto();
        $this->conn = Database::getInstance()->getConnection();
    }

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;

        $conditions = [];
        $bindings = [];

        if(isset($params['nome_codigo']) && !empty($params['nome_codigo'])){
            $conditions[] = "nome LIKE :nome_codigo OR codigo LIKE :nome_codigo";
            $bindings[':nome_codigo'] = "%" . $params['nome_codigo'] . "%";
        }

        if(isset($params['preco']) && !empty($params['preco'])){
            $conditions[] = "preco <= :preco";
            $bindings[':preco'] = number_format($params['preco'],2,".",".");
        }
    
        if(isset($params['ativo']) && $params['ativo'] != ""){
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['ativo'];
        }

        if(count($conditions) > 0){
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data){
        $produto = $this->model->create($data);

        try{
            
            $sql = "INSERT INTO " . self::TABLE . "
                SET 
                    uuid = :uuid,
                    nome = :nome,
                    codigo = :codigo,
                    preco = :preco,
                    estoque = :estoque,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $produto->uuid, 
                ':nome' => $produto->nome, 
                ':codigo' => $produto->codigo, 
                ':preco' => $produto->preco, 
                ':estoque' => $produto->estoque, 
                ':ativo' => $produto->ativo
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($produto->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id){
        $produto = $this->model->create($data);

        try{
            
            $sql = "UPDATE " . self::TABLE . "
                SET 
                    nome = :nome,
                    codigo = :codigo,
                    preco = :preco,
                    estoque = :estoque,
                    ativo = :ativo
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':nome' => $produto->nome,
                ':codigo' => $produto->codigo,
                ':preco' => $produto->preco,
                ':estoque' => $produto->estoque,
                ':ativo' => $produto->ativo,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Thorwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete($id){
        $sql = "UPDATE " . self::TABLE . "
            SET
                ativo = 0
            WHERE
                id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        $delete = $stmt->execute([
            ':id' => $id
        ]);

        return $delete;
    }

    public function subtractProduct(int $id, int $quantity){
        try{
            
            $sql = "UPDATE " . self::TABLE . "
                SET 
                    estoque = :estoque
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':estoque' => $quantity,
                ':id' => $id
            ]);

            return $update;

        }catch(\Thorwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}