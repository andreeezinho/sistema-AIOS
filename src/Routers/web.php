<?php

//importar
use App\Config\Router;
use App\Config\Auth;
use App\Controllers\User\UserController;
use App\Controllers\NotFound\NotFoundController;
use App\Controllers\Dashboard\DashboardController;
use App\Controllers\Permissao\PermissaoController;
use App\Controllers\Permissao\PermissaoUserController;
use App\Controllers\User\UserPerfilController;
use App\Controllers\Cliente\ClienteController;
use App\Controllers\Servico\ServicoController;
use App\Controllers\Produto\ProdutoController;

//instanciar
$router = new Router();
$auth = new Auth();
$userController = new UserController();
$notFoundController = new NotFoundController();
$dashboardController = new DashboardController();
$permissaoController = new PermissaoController();
$permissaoUserController = new PermissaoUserController();
$userPerfilController = new UserPerfilController();
$clienteController = new ClienteController();
$servicoController = new ServicoController();
$produtoController = new ProdutoController();

//rotas

//not-found
$router->create("GET", "/404", [$notFoundController, 'index']);

//login e logout
$router->create("GET", "/", [$userController, 'login'], null);
$router->create("POST", "/login", [$userController, 'auth'], null);
$router->create("GET", "/logout", [$userController, 'logout'], $auth);

//dashboard
$router->create("GET", "/dashboard", [$dashboardController, 'index'], $auth);

//usuarios
$router->create("GET", "/usuarios", [$userController, 'index'], $auth);
$router->create("GET", "/usuarios/cadastro", [$userController, 'create'], $auth);
$router->create("POST", "/usuarios/cadastro", [$userController, 'store'], $auth);
$router->create("GET", "/usuarios/{uuid}/editar", [$userController, 'edit'], $auth);
$router->create("POST", "/usuarios/{uuid}/editar", [$userController, 'update'], $auth);
$router->create("POST", "/usuarios/{uuid}/deletar", [$userController, 'destroy'], $auth);

//permissoes
$router->create("GET", "/permissoes", [$permissaoController, 'index'], $auth);
$router->create("GET", "/permissoes/cadastro", [$permissaoController, 'create'], $auth);
$router->create("POST", "/permissoes/cadastro", [$permissaoController, 'store'], $auth);
$router->create("GET", "/permissoes/{uuid}/editar", [$permissaoController, 'edit'], $auth);
$router->create("POST", "/permissoes/{uuid}/editar", [$permissaoController, 'update'], $auth);
$router->create("POST", "/permissoes/{uuid}/deletar", [$permissaoController, 'destroy'], $auth);

//permissao_user
$router->create("GET", "/usuarios/{uuid}/permissoes", [$permissaoUserController, 'index'], $auth);
$router->create("POST", "/usuarios/{uuid}/vincular", [$permissaoUserController, 'create'], $auth);
$router->create("POST", "/usuarios/{usuario_uuid}/desvincular/{permissao_uuid}", [$permissaoUserController, 'destroy'], $auth);

//perfil usuario
$router->create("GET", "/perfil", [$userPerfilController, 'index'], $auth);
$router->create("POST", "/perfil/icone", [$userPerfilController, 'updateIcone'], $auth);
$router->create("POST", "/perfil/editar", [$userPerfilController, 'updateDados'], $auth);
$router->create("POST", "/perfil/senha", [$userPerfilController, 'updateSenha'], $auth);
$router->create("POST", "/perfil/deletar", [$userPerfilController, 'destroy'], $auth);

//clientes
$router->create("GET", "/clientes", [$clienteController, 'index'], $auth);
$router->create("GET", "/clientes/cadastro", [$clienteController, 'create'], $auth);
$router->create("POST", "/clientes/cadastro", [$clienteController, 'store'], $auth);
$router->create("GET", "/clientes/{uuid}/editar", [$clienteController, 'edit'], $auth);
$router->create("POST", "/clientes/{uuid}/editar", [$clienteController, 'update'], $auth);
$router->create("POST", "/clientes/{uuid}/deletar", [$clienteController, 'destroy'], $auth);

//servicoes
$router->create("GET", "/servicos", [$servicoController, 'index'], $auth);
$router->create("GET", "/servicos/cadastro", [$servicoController, 'create'], $auth);
$router->create("POST", "/servicos/cadastro", [$servicoController, 'store'], $auth);
$router->create("GET", "/servicos/{uuid}/editar", [$servicoController, 'edit'], $auth);
$router->create("POST", "/servicos/{uuid}/editar", [$servicoController, 'update'], $auth);
$router->create("POST", "/servicos/{uuid}/deletar", [$servicoController, 'destroy'], $auth);

//produtos
$router->create("GET", "/produtos", [$produtoController, 'index'], $auth);
$router->create("GET", "/produtos/cadastro", [$produtoController, 'create'], $auth);
$router->create("POST", "/produtos/cadastro", [$produtoController, 'store'], $auth);


return $router;