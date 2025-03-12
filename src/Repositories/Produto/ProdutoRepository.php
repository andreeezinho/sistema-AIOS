<?php

namespace App\Repositories\Produto;

use App\Config\Database;
use App\Repositories\Traits\Find;
use App\Models\Produto\Produto;
use App\Repositories\Produto\ProdutoServicoRepository;

class ProdutoRepository {

    const CLASS_NAME = Produto::class;
    const TABLE = 'produtos';

    use Find;

    public $model;
    public $conn;

    public $produtoServicoRepository;

    public function __construct(){
        $this->model = new Produto();
        $this->conn = Database::getInstance()->getConnection();
        $this->produtoServicoRepository = new ProdutoServicoRepository();
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

        if(isset($params['estoque']) && $params['estoque'] != ""){
            $conditions[] = "estoque > :estoque";
            $bindings[':estoque'] = $params['estoque'];
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
        $produto = $this->model->create($data);

        try{
            
            $sql = "INSERT INTO " . self::TABLE . "
                SET 
                    uuid = :uuid,
                    nome = :nome,
                    codigo = :codigo,
                    preco = :preco,
                    estoque = :estoque,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $produto->uuid, 
                ':nome' => $produto->nome, 
                ':codigo' => $produto->codigo, 
                ':preco' => $produto->preco, 
                ':estoque' => $produto->estoque, 
                ':ativo' => $produto->ativo
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($produto->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id){
        $produto = $this->model->create($data);

        try{
            
            $sql = "UPDATE " . self::TABLE . "
                SET 
                    nome = :nome,
                    codigo = :codigo,
                    preco = :preco,
                    estoque = :estoque,
                    ativo = :ativo
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':nome' => $produto->nome,
                ':codigo' => $produto->codigo,
                ':preco' => $produto->preco,
                ':estoque' => $produto->estoque,
                ':ativo' => $produto->ativo,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Thorwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete($id){
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

    public function subtractProduct(int $id, int $quantity){
        try{
            
            $sql = "UPDATE " . self::TABLE . "
                SET 
                    estoque = :estoque
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':estoque' => $quantity,
                ':id' => $id
            ]);

            return $update;

        }catch(\Thorwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function verifyProductQuantity($all_products, $vendaProdutos){
        foreach($all_products as $produto_estoque){
            foreach($vendaProdutos as $produto){
                if($produto_estoque->id == $produto->produtos_id){
                    $quantidade = $produto_estoque->estoque;
                    if($produto_estoque->estoque > 0){
                        if(($quantidade - $produto->quantidade) < 0){
                            return false; break;
                        }

                        $quantidade = $quantidade - $produto->quantidade;
                    }
    
                    $subtractProduct = $this->subtractProduct($produto->produtos_id, $quantidade);
                }
            }
        }

        return true;
    }

    public function verifyProductServiceQuantity($all_products, $all_services, $osServices){
        foreach($all_products as $produto_estoque){
            foreach($all_services as $services){
                foreach($osServices as $osService){
                    $productsInService = $this->produtoServicoRepository->allProductsInService($osService->servicos_id);

                    if($services->id == $osService->servicos_id){
                        foreach($productsInService as $produto){
                            if($produto_estoque->id == $produto->produtos_id){
                                $quantidade = $produto_estoque->estoque;
                                if($produto_estoque->estoque > 0){
                                    $quantidade = $quantidade - 1;
                                }
                
                                $subtractProduct = $this->subtractProduct($produto->produtos_id, $quantidade);
                            }
                        }
                    }
                }
            }
        }
    }

}