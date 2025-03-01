<?php

namespace App\Repositories\User;

use App\Config\Database;
use App\Models\User\User;
use App\Repositories\Traits\Find;

class UserRepository{

    const CLASS_NAME = User::class;
    const TABLE = 'usuarios';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new User;
    }

    public function login(string $email, string $senha){
        if(empty($email) || empty($senha)){
            return null;
        }

        $sql = "SELECT * FROM " . self::TABLE . "
            WHERE 
                email = :email
                AND
                ativo = 1
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::CLASS_NAME);
        $user = $stmt->fetch();

        if(!$user){
            return null;
        }

        if(!password_verify($senha, $user->senha)){
            return null;
        }

        unset($user->senha);

        return $user;
    }

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;
    
        $conditions = [];
        $bindings = [];
    
        if(isset($params['nome_email']) && !empty($params['nome_email'])){
            $conditions[] = "nome LIKE :nome_email OR email LIKE :nome_email";
            $bindings[':nome_email'] = "%" . $params['nome_email'] . "%" ;
        }
    
        if(isset($params['cpf']) && !empty($params['cpf'])){
            $conditions[] = "cpf = :cpf";
            $bindings[':cpf'] = $params['cpf'];
        }
    
        if(isset($params['telefone']) && !empty($params['telefone'])){
            $conditions[] = "telefone = :telefone";
            $bindings[':telefone'] = $params['telefone'];
        }
    
        if(isset($params['ativo']) && $params['ativo'] != ""){
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['ativo'];
        }
    
        if(count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data){
        $data = array_merge($data, ['senha' => 'senha123']);
        $usuario = $this->model->create($data);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    nome = :nome,
                    email = :email,
                    cpf = :cpf,
                    telefone = :telefone,
                    senha = :senha,
                    ativo = :ativo,
                    icone = :icone
                ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $usuario->uuid,
                ':nome' => $usuario->nome,
                ':email' => $usuario->email,
                ':cpf' => $usuario->cpf,
                ':telefone' => $usuario->telefone,
                ':senha' => $usuario->senha,
                ':ativo' => $usuario->ativo,
                ':icone' => $usuario->icone
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($usuario->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->getConnection();
        }
    }

    public function update(array $data, int $id){
        $usuario = $this->model->create($data);

        try{

            $sql = "UPDATE " .self::TABLE . "
                SET
                    nome = :nome,
                    email = :email,
                    cpf = :cpf,
                    telefone = :telefone,
                    ativo = :ativo
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':nome' => $usuario->nome,
                ':email' => $usuario->email,
                ':cpf' => $usuario->cpf,
                ':telefone' => $usuario->telefone,
                ':ativo' => $usuario->ativo,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            $update = $this->findById($id);

            return $update;

        }catch(\Throwable $th){
            echo($th);
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function updateIcone(int $id, array $icone, string $dir){
        $updateIcone = createImage($icone, $dir);

        if(is_null($updateIcone)){
            return null;
        }

        try{

            $sql = "UPDATE " . self::TABLE . "
                SET
                    icone = :icone
                WHERE 
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':icone' => $updateIcone['arquivo_nome'],
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

    public function updateSenha(array $data, int $id){
        $usuario = $this->model->updateSenha($data);

        try{

            $sql = "UPDATE " .self::TABLE . "
                SET
                    senha = :senha
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':senha' => $usuario->senha,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            $update = $this->findById($id);

            return $update;

        }catch(\Throwable $th){
            echo($th);
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