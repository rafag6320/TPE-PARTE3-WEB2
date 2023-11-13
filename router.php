<?php
    require_once 'config.php';
    require_once 'libs/router.php';
    require_once 'app/controllers/task.api.controller.php';

    $router = new Router();

    #                 endpoint      verbo     controller           método
    $router->addRoute('productos',     'GET',    'TaskApiController', 'get'   ); # TaskApiController->get($params)
    $router->addRoute('productoscreciente',     'GET',    'TaskApiController', 'getCreciente'   );
    $router->addRoute('productosdecreciente',     'GET',    'TaskApiController', 'getDecreciente'   );
    $router->addRoute('producto',     'POST',   'TaskApiController', 'create');
    $router->addRoute('producto/:ID', 'GET',    'TaskApiController', 'get'   );
    $router->addRoute('producto/:ID', 'PUT',    'TaskApiController', 'update');
    $router->addRoute('producto/:ID', 'DELETE', 'TaskApiController', 'deleteTask');
        
    #               del htaccess resource=(), verbo con el que llamo GET/POST/PUT/etc
    $router->route($_GET['resource']        , $_SERVER['REQUEST_METHOD']);