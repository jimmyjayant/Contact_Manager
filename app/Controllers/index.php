<?php

define('BASE_URL', '/Projects/Contact_Manager/Website/public/');
define('BASE_DIR', '/Projects/Contact_Manager/Website');

$getURL = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'index';
//echo $getURL;

$get_url_parts = explode('/', $getURL);
$getPage = $get_url_parts[0];

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    switch($getPage)
    {
        case 'index':
        case '':
        case 'home':
        case 'index.php':
        case '/':
        case 'home.php':
            require '../app/Views/index.php';
            break;

        case 'changepassword':
        case 'changepassword.php':
            require '../app/Views/changepassword.php';
            break;
        
        case 'dashboard':
        case 'dashboard.php':
            require '../app/Views/dashboard.php';
            break;

        case 'register':
        case 'register.php':
            require '../app/Views/register.php';
            break;

        case 'login':
        case 'login.php':
            require '../app/Views/login.php';
            break;

        case 'logout':
        case 'logout.php':
            require '../app/Views/logout.php';
            break;

        case 'feedback':
        case 'feedback.php':
            require '../app/Views/feedback.php';
            break;
        
        case 'docs':
        case 'docs.php':
            require '../app/Views/docs.php';
            break;

        case 'sitemap':
        case 'sitemap.php':
            require '../app/Views/sitemap.php';
            break;

        case 'get_user_contacts':
        case 'get_user_contacts.php':
            require '../app/Models/get_user_contacts.php';
            break;

        case 'search_user_contacts':
        case 'search_user_contacts.php':
            require '../app/Models/search_user_contacts.php';
            break;

        /*
        case 'createusertable':
            require '../app/Config/Database_Connection.php';
            break;
        */

        default:
            // Send 404 status header
            http_response_code(404);
            require '../app/Views/404.php';
            break;
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    switch($getPage)
    {
        case 'add_user_contact':
        case 'add_user_contact.php':
            require '../app/Models/add_user_contact.php';
            break;

        case 'filter_user_contact':
        case 'filter_user_contact.php':
            require '../app/Models/filter_user_contact.php';
            break;

        case 'get_user_data':
        case 'get_user_data.php':
            require '../app/Models/get_user_data.php';
            break;

        case 'provide_feedback':
        case 'provide_feedback.php':
            require '../app/Models/provide_feedback.php';
            break;

        case 'register_user_data':
        case 'register_user_data.php':
            require '../app/Models/register_user_data.php';
            break;

        default:
            // Send 404 status header
            http_response_code(404);
            require '../app/Views/404.php';
            break;
    }
}
?>
