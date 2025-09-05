<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';


define("BASE_PATH", dirname(__DIR__));
define("BASE_VIEW_PATH", BASE_PATH . '/views');
define("BASE_RESOURCE", dirname($_SERVER['SCRIPT_NAME']) . 'assets');

const ROUTES = [
    'home'        => '/',

    // YEAR
    'year.index'   => '/years',
    'year.show'    => '/year/:id',
    'year.closed'  => '/year/:id/closed',
    'year.destroy' => '/year/:id/destroy',

    // LEVEL
    'level.index'   => '/levels',
    'level.create'  => '/level/create',        
    'level.store'   => '/level/create/store',  
    'level.edit'    => '/level/:id/edit',
    'level.update'  => '/level/:id/update',
    'level.show'    => '/level/:id/show',
    'level.destroy' => '/level/:id/destroy',

    // COURSE
    'course.index'   => '/courses',
    'course.create'  => '/course/create',        
    'course.store'   => '/course/create/store',  
    'course.edit'    => '/course/:id/edit',
    'course.update'  => '/course/:id/update',
    'course.show'    => '/course/:id/show',
    'course.destroy' => '/course/:id/destroy',

    // AUTH
    'auth.login'   => '/login',
    'auth.store'  => '/login/store',   
    'auth.logout'  => '/logout',   
];

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

$match = matchRoute($url);

if ($match) {
    $routeParams = $match['params'];

    switch ($match['name']) {
        case 'home':
            require BASE_VIEW_PATH . '/welcome.php';
            break;
        // YEAR ROUTES
        case 'year.index':
            require BASE_VIEW_PATH . '/year/index.php';
            break;
        case 'year.show':
            require BASE_VIEW_PATH . '/year/show.php';
            break;
        case 'year.closed':
            require BASE_VIEW_PATH . '/year/closed.php';
            break;
        case 'year.destroy':
            require BASE_VIEW_PATH . '/year/destroy.php';
            break;
        // END YEAR ROUTES
        // LEVELS ROUTES
        case 'level.index':
            require BASE_VIEW_PATH . '/level/index.php';
            break;
        case 'level.show':
            require BASE_VIEW_PATH . '/level/show.php';
            break;
        case 'level.destroy':
            require BASE_VIEW_PATH . '/level/destroy.php';
            break;
        case 'level.edit':
            require BASE_VIEW_PATH . '/level/edit.php';
            break;
        case 'level.update':
            require BASE_VIEW_PATH . '/level/update.php';
            break;
        case 'level.create':
            require BASE_VIEW_PATH . '/level/create.php';
            break;
        case 'level.store':
            require BASE_VIEW_PATH . '/level/store.php';
            break;
        // END LEVELS ROUTES


        // COURSES ROUTES
        case 'course.index':
            require BASE_VIEW_PATH . '/course/index.php';
            break;
        case 'course.show':
            require BASE_VIEW_PATH . '/course/show.php';
            break;
        case 'course.destroy':
            require BASE_VIEW_PATH . '/course/destroy.php';
            break;
        case 'course.edit':
            require BASE_VIEW_PATH . '/course/edit.php';
            break;
        case 'course.update':
            require BASE_VIEW_PATH . '/course/update.php';
            break;
        case 'course.create':
            require BASE_VIEW_PATH . '/course/create.php';
            break;
        case 'course.store':
            require BASE_VIEW_PATH . '/course/store.php';
            break;
        // END COURSES ROUTES


        // LOGIN
        case 'auth.login':
            require BASE_VIEW_PATH . '/auth/login.php';
            break;
        case 'auth.store':
            require BASE_VIEW_PATH . '/auth/store.php';
            break;
        case 'auth.logout':
            require BASE_VIEW_PATH . '/auth/logout.php';
            break;
        // END LOGIN

        default:
            http_response_code(404);
            require BASE_VIEW_PATH . '/404.php';
    }
} else {
    http_response_code(404);
    require BASE_VIEW_PATH . '/404.php';
}
