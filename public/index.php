<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

define("BASE_PATH", dirname(__DIR__));
define("BASE_VIEW_PATH", BASE_PATH . '/views');
define("BASE_RESOURCE", dirname($_SERVER['SCRIPT_NAME']) . 'assets');

const DB_NAME = 'school_deliberation_app';
const DB_USERNAME = 'root';
const DB_PWD = 'demo';

const GENDERS = ['M', 'F'];

const PERIODS = [
    'Période 1'         => 'Période 1',
    'Période 2'         => 'Période 2',
    'Examen Semestre 1'    => 'Examen Semestre 1',
    'Période 3'         => 'Période 3',
    'Période 4'         => 'Période 4',
    'Examen Semestre 2'    => 'Examen Semestre 2',
];

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
    'auth.store'   => '/login/store',   
    'auth.logout'  => '/logout', 
    // STUDENT
    'student.index'   => '/students',
    'student.create'  => '/student/create',        
    'student.store'   => '/student/create/store',  
    'student.edit'    => '/student/:id/edit',
    'student.update'  => '/student/:id/update',
    'student.show'    => '/student/:id/show',
    'student.destroy' => '/student/:id/destroy',

    // NOTE
    'note.index'   => '/notes',
    'note.create'  => '/note/create',        
    'note.store'   => '/note/create/store',  
    'note.edit'    => '/note/:id/edit',
    'note.update'  => '/note/:id/update',
    'note.show'    => '/note/:id/show',
    'note.destroy' => '/note/:id/destroy',

    // RESULT
    'result.index'   => '/results',
    'result.create'  => '/result/create',        
    'result.store'   => '/result/create/store',
    'result.show' => '/result/:id/show',
];

try {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    $match = matchRoute($url);

    if (!$match) {
        throw new Exception("Page non trouvée", 404);
    }

    $routeParams = $match['params'] ?? [];

    switch ($match['name']) {
        case 'home':
            require BASE_VIEW_PATH . '/welcome.php';
            break;

        // YEAR ROUTES
        case 'year.index': require BASE_VIEW_PATH . '/year/index.php'; break;
        case 'year.show': require BASE_VIEW_PATH . '/year/show.php'; break;
        case 'year.closed': require BASE_VIEW_PATH . '/year/closed.php'; break;
        case 'year.destroy': require BASE_VIEW_PATH . '/year/destroy.php'; break;

        // LEVEL ROUTES
        case 'level.index': require BASE_VIEW_PATH . '/level/index.php'; break;
        case 'level.show': require BASE_VIEW_PATH . '/level/show.php'; break;
        case 'level.destroy': require BASE_VIEW_PATH . '/level/destroy.php'; break;
        case 'level.edit': require BASE_VIEW_PATH . '/level/edit.php'; break;
        case 'level.update': require BASE_VIEW_PATH . '/level/update.php'; break;
        case 'level.create': require BASE_VIEW_PATH . '/level/create.php'; break;
        case 'level.store': require BASE_VIEW_PATH . '/level/store.php'; break;

        // COURSE ROUTES
        case 'course.index': require BASE_VIEW_PATH . '/course/index.php'; break;
        case 'course.show': require BASE_VIEW_PATH . '/course/show.php'; break;
        case 'course.destroy': require BASE_VIEW_PATH . '/course/destroy.php'; break;
        case 'course.edit': require BASE_VIEW_PATH . '/course/edit.php'; break;
        case 'course.update': require BASE_VIEW_PATH . '/course/update.php'; break;
        case 'course.create': require BASE_VIEW_PATH . '/course/create.php'; break;
        case 'course.store': require BASE_VIEW_PATH . '/course/store.php'; break;

        // AUTH
        case 'auth.login': require BASE_VIEW_PATH . '/auth/login.php'; break;
        case 'auth.store': require BASE_VIEW_PATH . '/auth/store.php'; break;
        case 'auth.logout': require BASE_VIEW_PATH . '/auth/logout.php'; break;

        // STUDENT ROUTES
        case 'student.index': require BASE_VIEW_PATH . '/student/index.php'; break;
        case 'student.show': require BASE_VIEW_PATH . '/student/show.php'; break;
        case 'student.destroy': require BASE_VIEW_PATH . '/student/destroy.php'; break;
        case 'student.edit': require BASE_VIEW_PATH . '/student/edit.php'; break;
        case 'student.update': require BASE_VIEW_PATH . '/student/update.php'; break;
        case 'student.create': require BASE_VIEW_PATH . '/student/create.php'; break;
        case 'student.store': require BASE_VIEW_PATH . '/student/store.php'; break;

        // NOTE ROUTES
        case 'note.index': require BASE_VIEW_PATH . '/note/index.php'; break;
        case 'note.show': require BASE_VIEW_PATH . '/note/show.php'; break;
        case 'note.destroy': require BASE_VIEW_PATH . '/note/destroy.php'; break;
        case 'note.edit': require BASE_VIEW_PATH . '/note/edit.php'; break;
        case 'note.update': require BASE_VIEW_PATH . '/note/update.php'; break;
        case 'note.create': require BASE_VIEW_PATH . '/note/create.php'; break;
        case 'note.store': require BASE_VIEW_PATH . '/note/store.php'; break;

        // RESULT
        case 'result.index': require BASE_VIEW_PATH . '/result/index.php'; break;
        case 'result.create': require BASE_VIEW_PATH . '/result/create.php'; break;
        case 'result.store': require BASE_VIEW_PATH . '/result/store.php'; break;
        case 'result.show': require BASE_VIEW_PATH . '/result/show.php'; break;


        default:
            throw new Exception("Page non trouvée", 404);
    }

} catch (\Exception $e) {
    // Définir le code HTTP approprié
    $code = $e->getCode();
    http_response_code(is_string($code) ? (int)$code : $code);

    // Tu peux afficher une page 404 ou 500 personnalisée
    $errorMessage = $e->getMessage();
    require BASE_VIEW_PATH . '/error.php';
}
