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
        
    }

}