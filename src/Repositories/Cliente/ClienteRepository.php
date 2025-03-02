<?php

namespace App\Repositories\Cliente;

use App\Config\Database;
use App\Models\Cliente\Cliente;
use App\Repositories\Traits\Find;
use App\Repositories\User\UserRepository;

class ClienteRepository {

    const CLASS_NAME = Cliente::class;
    const TABLE = 'clientes';

    use Find;

    protected $conn;
    protected $model;
    protected $userRepository;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Cliente();
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

        if(isset($params['cpf']) && !empty($params['cpf'])){
            $conditions[] = "cpf LIKE :cpf";
            $bindings[':cpf'] = "%" . $params['cpf'] . "%";
        }
    
        if(isset($params['ativo']) && $params['ativo'] != ""){
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['ativo'];
        }

        if(count($conditions) > 0){
            $sql .= " WHERE " . implode(" AND ", $condiitons);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare();

        $stmt->execute($bindings);

        return $stmt->fecthAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
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
                ':email' => $cliente->uuid,
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

}