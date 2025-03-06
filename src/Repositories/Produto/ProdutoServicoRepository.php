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

    public function linkProduct(int $servico_id, int $produto_id){
        $produtoServico = $this->model->create($produto_id, $servico_id);
        try{
            
            $sql = "INSERT INTO ". self::TABLE . "
                SET 
                    uuid = :uuid,
                    servicos_id = :servicos_id,
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $produtoServico->uuid,
                ':servicos_id' => $servico_id,
                ':produtos_id' => $produto_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($produtoServico->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function unlinkProduct(int $servico_id, int $produto_id, int $id){
        try{
            
            $sql = "DELETE FROM ". self::TABLE . "
                WHERE
                    id = :id 
                AND
                    servicos_id = :servicos_id
                AND
                    produtos_id = :produtos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $delete = $stmt->execute([
                ':id' => $id,
                ':servicos_id' => $servico_id,
                ':produtos_id' => $produto_id
            ]);

            return $delete;

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }
}
