<?php

namespace App\Repositories\OS;

use App\Config\Database;
use App\Repositories\Traits\Find;
use App\Models\OS\OSServico;

class OSServicoRepository {

    const CLASS_NAME = OSServico::class;
    const TABLE = 'os_servico';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new OSServico();
    }

    public function allServicesInOS($os_id){
        $sql = "SELECT os_s.*,
			os.id as os,
            s.nome as nome, s.descricao, s.preco, s.uuid as uuidServico
            FROM " . self::TABLE . " os_s
            JOIN os os
                ON os_id = os.id
            JOIN servicos s
                ON servicos_id = s.id
            WHERE os.id = :os_id
            ORDER BY os_s.created_at ASC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':os_id' => $os_id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function linkService(int $os_id, int $servicos_id){
        $osServico = $this->model->create($os_id, $servicos_id);
        try{
            
            $sql = "INSERT INTO ". self::TABLE . "
                SET 
                    uuid = :uuid,
                    os_id = :os_id,
                    servicos_id = :servicos_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $osServico->uuid,
                ':os_id' => $os_id,
                ':servicos_id' => $servicos_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($osServico->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}