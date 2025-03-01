<?php

namespace App\Repositories\Permissao;

use App\Config\Database;
use App\Models\Permissao\Permissao;
use App\Repositories\Traits\Find;
use App\Repositories\User\UserRepository;

class PermissaoRepository {

    const CLASS_NAME = Permissao::class;
    const TABLE = 'permissoes';

    use Find;

    protected $conn;
    protected $model;
    protected $userRepository;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Permissao();
        $this->userRepository = new UserRepository();
    }

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;
    
        $conditions = [];
        $bindings = [];
    
        if(isset($params['nome']) && !empty($params['nome'])){
            $conditions[] = "nome LIKE :nome";
            $bindings[':nome'] = "%" . $params['nome'] . "%";
        }

        if(isset($params['tipo']) && $params['tipo'] != ""){
            $conditions[] = "tipo = :tipo";
            $bindings[':tipo'] = $params['tipo'];
        }
    
        if(isset($params['ativo']) && $params['ativo'] != ""){
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['ativo'];
        }
    
        if(count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data){
        $permissao = $this->model->create($data);

        try{
            
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    nome = :nome,
                    tipo = :tipo,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $permissao->uuid,
                ':nome' => $permissao->nome,
                ':tipo' => $permissao->tipo,
                ':ativo' => $permissao->ativo
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($permissao->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id){
        $permissao = $this->model->create($data);

        try{

            $sql = "UPDATE " . self::TABLE . "
                SET
                    nome = :nome,
                    tipo = :tipo,
                    ativo = :ativo
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':nome' => $permissao->nome,
                ':tipo' => $permissao->tipo,
                ':ativo' => $permissao->ativo,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable){
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

}