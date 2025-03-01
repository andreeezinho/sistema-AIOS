<?php

namespace App\Repositories\Permissao;

use App\Config\Database;
use App\Models\Permissao\PermissaoUser;
use App\Repositories\Traits\Find;
use App\Repositories\User\UserRepository;

class PermissaoUserRepository {

    const CLASS_NAME = PermissaoUser::class;
    const TABLE = 'permissao_usuario';

    use Find;

    protected $conn;
    protected $model;
    protected $userRepository;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new PermissaoUser();
        $this->userRepository = new UserRepository();
    }

    public function allUserPermissions(int $usuario_id){
        $sql = "SELECT pu.id, pu.uuid, p.nome FROM " . self::TABLE . " pu
            JOIN permissoes p 
            ON pu.permissoes_id = p.id
            WHERE pu.usuarios_id = :usuario_id
            ORDER BY pu.id ASC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuario_id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function linkUserPermission(int $usuario_id, int $permissao_id){
        $permissao_user = $this->model->create($usuario_id, $permissao_id);
        
        try{

            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    permissoes_id = :permissoes_id,
                    usuarios_id = :usuarios_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $permissao_user->uuid,
                ':permissoes_id' => $permissao_user->permissoes_id,
                ':usuarios_id' => $permissao_user->usuarios_id,
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($permissao_user->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function unlinkUserPermission(int $usuario_id, int $permissao_id){
        $sql = "DELETE FROM " . self::TABLE . "
            WHERE
                permissoes_id = :permissoes_id
                AND
                usuarios_id = :usuarios_id
        ";

        $stmt = $this->conn->prepare($sql);

        $delete = $stmt->execute([
            ':permissoes_id' => $permissao_id,
            ':usuarios_id' => $usuario_id
        ]);

        return $delete;
    }

}