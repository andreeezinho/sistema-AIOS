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

}