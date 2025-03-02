<?php

namespace App\Repositories\Servico;

use App\Config\Database;
use App\Models\Servico\Servico;
use App\Repositories\Traits\Find;

class ServicoRepository {

    const CLASS_NAME = Servico::class;
    const TABLE = 'servicos';

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
        
    }

}