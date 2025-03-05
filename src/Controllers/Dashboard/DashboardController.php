<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Config\Auth;
use App\Repositories\User\UserRepository;
use App\Repositories\Cliente\ClienteRepository;
use App\Repositories\Servico\ServicoRepository;
use App\Repositories\Produto\ProdutoRepository;
use App\Repositories\Venda\VendaRepository;
use App\Repositories\OS\OSRepository;

class DashboardController extends Controller {

    protected $auth;
    protected $userRepository;
    protected $clienteRepository;
    protected $servicoRepository;
    protected $produtoRepository;
    protected $vendaRepository;
    protected $osRepository;

    public function __construct(){
        parent::__construct();
        $this->auth = new Auth();
        $this->userRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
        $this->servicoRepository = new ServicoRepository();
        $this->produtoRepository = new ProdutoRepository();
        $this->vendaRepository = new VendaRepository();
        $this->osRepository = new OSRepository();
    }

    public function index(){
        $user = $this->auth->user();

        $usuarios = $this->userRepository->all();
        $clientes = $this->clienteRepository->all();
        $servicos = $this->servicoRepository->all();
        $produtos = $this->produtoRepository->all();
        $vendas = $this->vendaRepository->all();
        $userVendas = $this->vendaRepository->all(['usuario' => $_SESSION['user']->cpf]);
        $os = $this->osRepository->all();
        $userOs = $this->osRepository->all(['usuario' => $_SESSION['user']->cpf]);

        return $this->router->view('dashboard/index', [
            'user' => $user,
            'usuarios' => $usuarios,
            'clientes' => $clientes,
            'servicos' => $servicos,
            'produtos' => $produtos,
            'vendas' => $vendas,
            'userVendas' => $userVendas,
            'os' => $os,
            'userOs' => $userOs
        ]);
    }

}