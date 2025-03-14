<?php

namespace App\Repositories\OS;

use App\Config\Database;
use App\Repositories\Traits\Find;
use App\Models\OS\OS;

class OSRepository {

    const CLASS_NAME = OS::class;
    const TABLE = 'os';

    use Find;

    protected $conn;
    protected $model;
    
    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new OS();
    }

    public function all(array $params = []){
        $sql = "SELECT os.*, 
            c.nome as cliente, c.documento as documento, 
            u.nome as usuario, u.cpf as cpf 
            FROM " .self::TABLE. " os
            JOIN clientes c
                ON clientes_id = c.id
            JOIN usuarios u
                ON usuarios_id = u.id
        ";

        $conditions = [];
        $bindings = [];

        if(isset($params['cliente']) && !empty($params['cliente'])){
            $conditions[] = "c.nome LIKE :cliente OR c.documento LIKE :cliente";
            $bindings[':cliente'] = "%" . $params['cliente'] . "%";
        }

        if(isset($params['usuario']) && !empty($params['usuario'])){
            $conditions[] = "u.nome LIKE :usuario OR u.cpf LIKE :usuario";
            $bindings[':usuario'] = "%" . $params['usuario'] . "%";
        }

        if(isset($params['dispositivo']) && !empty($params['dispositivo'])){
            $conditions[] = "os.dispositivo LIKE :dispositivo";
            $bindings[':dispositivo'] = "%" . $params['dispositivo'] . "%";
        }

        if(isset($params['data']) && !empty($params['data'])){
            $conditions[] = "date_format(os.created_at, '%d/%m/%Y') = date_format(:data, '%d/%m/%Y')";
            $bindings[':data'] = $params['data'];
        }

        if(isset($params['situacao']) && $params['situacao'] != ""){
            $conditions[] = "situacao = :situacao";
            $bindings[':situacao'] = $params['situacao'];
        }

        if(count($conditions) > 0){
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data, int $usuario_id, int $cliente_id){
        $os = $this->model->create($data, $usuario_id, $cliente_id);
        
        try{

            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    desconto = :desconto,
                    dispositivo = :dispositivo,
                    observacao = :observacao,
                    situacao = :situacao,
                    clientes_id = :clientes_id,
                    usuarios_id = :usuarios_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $os->uuid,
                ':desconto' => $os->desconto,
                ':dispositivo' => $os->dispositivo,
                ':observacao' => $os->observacao,
                ':situacao' => $os->situacao,
                ':clientes_id' => $os->clientes_id,
                ':usuarios_id' => $os->usuarios_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($os->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $usuarios_id, int $clientes_id, int $id){
        $os = $this->model->create($data, $usuarios_id, $clientes_id);
        
        try{

            $sql = "UPDATE " . self::TABLE . "
                SET
                    desconto = :desconto,
                    dispositivo = :dispositivo,
                    observacao = :observacao,
                    situacao = :situacao
                WHERE 
                    id = :id
            "; 

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':desconto' => $os->desconto,
                ':dispositivo' => $os->dispositivo,
                ':observacao' => $os->observacao,
                ':situacao' => $os->situacao,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable $th){
            dd($th);
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function finish(float $total, int $id){
        try{

            $sql = "UPDATE " . self::TABLE . "
                SET
                    total = :total,
                    situacao = :situacao
                WHERE 
                    id = :id
            "; 

            $stmt = $this->conn->prepare($sql);

            $finish = $stmt->execute([
                ':total' => $total,
                ':situacao' => 'concluida',
                ':id' => $id
            ]);

            if(!$finish){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable $th){
            dd($th);
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function cancel(int $id){
        try{

            $sql = "UPDATE " . self::TABLE . "
                SET
                    situacao = :situacao
                WHERE 
                    id = :id
            "; 

            $stmt = $this->conn->prepare($sql);

            $cancel = $stmt->execute([
                ':situacao' => 'cancelada',
                ':id' => $id
            ]);

            if(!$cancel){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable $th){
            dd($th);
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}