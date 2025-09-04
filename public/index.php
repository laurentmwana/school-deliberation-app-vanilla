<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';


define("BASE_PATH", dirname(__DIR__));
define("BASE_VIEW_PATH", BASE_PATH . '/views');
define("BASE_RESOURCE", dirname($_SERVER['SCRIPT_NAME']) . 'assets');

const ROUTES = [
    'home'        => '/',
    'year.index'  => '/years',
    'year.show'   => '/year/:id',
    'year.closed'   => '/year/:id/closed',
    'year.destroy'=> '/year/:id/destroy',
];

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

$match = matchRoute($url);

if ($match) {
    $routeParams = $match['params'];

    switch ($match['name']) {
        case 'home':
            require BASE_VIEW_PATH . '/welcome.php';
            break;
        case 'year.index':
            require BASE_VIEW_PATH . '/year/index.php';
            break;
        case 'year.show':
            // $match['params']['id'] contient l’ID
            require BASE_VIEW_PATH . '/year/show.php';
            break;
        case 'year.closed':
            require BASE_VIEW_PATH . '/year/closed.php';
            break;

        case 'year.destroy':
            // $match['params']['id'] contient l’ID
            require BASE_VIEW_PATH . '/year/destroy.php';
            break;
        default:
            http_response_code(404);
            require BASE_VIEW_PATH . '/404.php';
    }
} else {
    http_response_code(404);
    require BASE_VIEW_PATH . '/404.php';
}
