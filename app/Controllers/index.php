<?php

define('BASE_URL', '/Projects/Contact_Manager/Website/public/');
define('BASE_DIR', '/Projects/Contact_Manager/Website');

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'index';

$url_parts = explode('/', $url);
$page = $url_parts[0];

switch($page)
{
    case 'index':
    case '':
    case 'home':
        require '../app/Views/index.php';
        break;

    case 'dashboard':
        require '../app/Views/dashboard.php';
        break;

    case 'register':
        require '../app/Views/register.php';
        break;

    case 'login':
        require '../app/Views/login.php';
        break;

    case 'logout':
        require '../app/Views/logout.php';
        break;

    case 'get_user_data':
        require '../app/Models/get_user_data.php';
        break;

    case 'register_user_data':
        require '../app/Models/register_user_data.php';
        break;
    
    case 'provide_feedback':
        require '../app/Models/provide_feedback.php';
        break;

    case 'feedback':
        require '../app/Views/feedback.php';
        break;
    
    case 'docs':
        require '../app/Views/docs.php';
        break;

    case 'sitemap':
        require '../app/Views/sitemap.php';
        break;

    default:
        // Send 404 status header
        http_response_code(404);
        require '../app/Views/404.php';
        break;
}
?>
