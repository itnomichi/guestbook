<?php
require_once "$dir/app/controllers/UserController.php";
require_once "$dir/app/controllers/SiteController.php";
require_once "$dir/app/controllers/CommentController.php";

class Router
{
    public $routes = [];

    public function __construct()
    {
        $this->routes['GET'] = [
            '/' => [
                'controller' => 'SiteController',
                'action' => 'index'
            ],
            '/signin' => [
                'controller' => 'SiteController',
                'action' => 'signin'
            ],
            '/signout' => [
                'controller' => 'UserController',
                'action' => 'signout'
            ]
        ];

        $this->routes['POST'] = [
            '/signin' => [
                'controller' => 'UserController',
                'action' => 'signin'
            ],
            '/create' => [
                'controller' => 'CommentController',
                'action' => 'create'
            ],
            '/update' => [
                'controller' => 'CommentController',
                'action' => 'update'
            ],
            '/delete' => [
                'controller' => 'CommentController',
                'action' => 'delete'
            ]
        ];
    }

    public function dispatch()
    {
        try {

            $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
            $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';

            if (!isset($this->routes[$method]))
                return Err::response($e, 404);

            if (!isset($this->routes[$method][$uri]))
                return Err::response($e, 404);

            $r_controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];
            $controller = new $r_controller();
            $controller->$action();

        } catch (\Throwable $e) {
            return Err::response($e, 500);
        }
    }
}