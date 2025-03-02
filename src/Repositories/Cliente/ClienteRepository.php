<?php

namespace App\Repositories\Cliente;

use App\Config\Database;
use App\Models\Cliente\Cliente;
use App\Repositories\Traits\Find;

class ClienteRepository {

    const CLASS_NAME = Cliente::class;
    const TABLE = 'clientes';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Cliente();
    }

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;

        $conditions = [];
        $bindings = [];

        if(isset($params['nome']) && !empty($params['nome'])){
            $conditions[] = "nome LIKE :nome";
            $bindings[':nome'] = "%" . $params['nome'] . "%";
        }

        if(isset($params['documento']) && !empty($params['documento'])){
            $conditions[] = "documento LIKE :documento";
            $bindings[':documento'] = "%" . $params['documento'] . "%";
        }
    
        if(isset($params['ativo']) && $params['ativo'] != ""){
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['ativo'];
        }

        if(count($conditions) > 0){
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data){
        $cliente = $this->model->create($data);

        try{

            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    nome = :nome,
                    email = :email,
                    documento = :documento,
                    telefone = :telefone,
                    endereco = :endereco,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $cliente->uuid,
                ':nome' => $cliente->nome,
                ':email' => $cliente->email,
                ':documento' => $cliente->documento,
                ':telefone' => $cliente->telefone,
                ':endereco' => $cliente->endereco,
                ':endereco' => $cliente->endereco,
                ':ativo' => $cliente->ativo,
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($cliente->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function edit(array $data, int $id){
        $cliente = $this->model->create($data);

        try{

            $sql = "UPDATE " . self::TABLE . "
                SET
                    nome = :nome,
                    email = :email,
                    documento = :documento,
                    telefone = :telefone,
                    endereco = :endereco,
                    ativo = :ativo
                WHERE 
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':nome' => $cliente->nome,
                ':email' => $cliente->email,
                ':documento' => $cliente->documento,
                ':telefone' => $cliente->telefone,
                ':endereco' => $cliente->endereco,
                ':endereco' => $cliente->endereco,
                ':ativo' => $cliente->ativo,
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