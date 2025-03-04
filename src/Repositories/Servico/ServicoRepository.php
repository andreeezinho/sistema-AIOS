<?php

namespace App\Repositories\Servico;

use App\Config\Database;
use App\Models\Servico\Servico;
use App\Repositories\Traits\Find;

class ServicoRepository {

    const CLASS_NAME = Servico::class;
    const TABLE = 'servicos';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Servico();
    }

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;

        $conditions = [];
        $bindings = [];

        if(isset($params['nome']) && !empty($params['nome'])){
            $conditions[] = "nome LIKE :nome";
            $bindings[':nome'] = "%" . $params['nome'] . "%";
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
        $servico = $this->model->create($data);

        try{

            $sql = "INSERT INTO ". self::TABLE . "
                SET 
                    uuid = :uuid,
                    nome = :nome,
                    descricao = :descricao,
                    preco = :preco,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $servico->uuid,
                ':nome' => $servico->nome,
                ':descricao' => $servico->descricao,
                ':preco' => $servico->preco,
                ':ativo' => $servico->ativo
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($servico->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id){
        $servico = $this->model->create($data);

        try{

            $sql = "UPDATE " . self::TABLE . "
                SET 
                    nome = :nome,
                    descricao = :descricao,
                    preco = :preco,
                    ativo = :ativo
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':nome' => $servico->nome,
                ':descricao' => $servico->descricao,
                ':preco' => $servico->preco,
                ':ativo' => $servico->ativo,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($servico->id);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete(int $id){
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

    public function updatePrice(float $total, int $id){
        try{

            $sql = "UPDATE " . self::TABLE . "
                SET 
                    preco = :preco
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':preco' => $total,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}