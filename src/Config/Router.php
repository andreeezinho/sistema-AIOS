<?php

namespace App\Config;

use App\Request\Request;
use App\Config\Auth;

class Router {

    protected $routers = [];
    protected $auth = null;

    public function create(string $method, string $path, callable $callback, Auth $auth = null){
        $this->auth = $auth;
        $normalizedPath = $this->normalizePath($path);

        if(!is_null($this->auth) && !$this->auth->check()){
            return $this->view('login/login', [
                'erro' => 'Faça login para continuar'
            ]);
        }

        $this->routers[$method][$normalizedPath] = $callback;
        $this->init();
    }

    public function init(){
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        $request = new Request();

        $normalizedRequestUri = $this->normalizePath($requestUri);
        $normalizedRequestUri = rtrim($normalizedRequestUri, '/');

        if(isset($this->routers[$httpMethod])){
            foreach($this->routers[$httpMethod] as $path => $callback){
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $path);
                $pattern = '/^' . str_replace('/', '\/', $pattern) . '\/?$/';

                if(preg_match($pattern, $normalizedRequestUri, $matches)){
                    array_shift($matches);
                    return call_user_func_array($callback, array_merge([$request], $matches));
                }
            }
        }
    }

    private function normalizePath($path){
        return rtrim(parse_url($path, PHP_URL_PATH), '/');
    }

    public function view(string $viewName, array $data = []){
        extract($data);
        require_once __DIR__ . '/../Resources/Views/' . $viewName . '.php';
        exit();
    }

    public function redirect(string $page, float $delay = 0){
        $url = URL_SITE . '/' . $page;
        echo "<meta http-equiv='refresh' content='{$delay};url={$url}'>";
        exit();
    }
}