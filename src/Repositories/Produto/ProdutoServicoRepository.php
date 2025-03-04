<?php

namespace App\Repositories\Produto;

use App\Config\Database;
use App\Repositories\Traits\Find;
use App\Models\Produto\ProdutoServico;

class ProdutoServicoRepository {

    const CLASS_NAME = ProdutoServico::class;
    const TABLE = 'produto_servico';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new ProdutoServico();
    }

    public function allProductsInService(int $servico_id){
        $sql = "SELECT ps.*,
            p.nome as nome, p.codigo as codigo, p.preco, p.uuid as uuidProduto,
            s.id as servico
            FROM " . self::TABLE . " ps
            JOIN produtos p
                ON produtos_id = p.id
            JOIN servicos s
                ON servicos_id = s.id
            WHERE 
                s.id = :servico_id
            ORDER BY ps.created_at ASC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':servico_id' => $servico_id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }
}
