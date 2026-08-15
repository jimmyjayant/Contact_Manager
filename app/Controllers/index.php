<?php

define('BASE_URL', '/Projects/Contact_Manager/Website/public/');
define('BASE_DIR', '/Projects/Contact_Manager/Website');

function requireFile(string $pathToFile)
{
    if(!file_exists($pathToFile))
    {
        $errorMsg = "File is not present at " . $pathToFile;
        error_log($errorMsg, 3, "../writable/logs/file_error_log.txt");
        // Send 404 status header
        http_response_code(503);
        require_once '../app/Views/503.php';
        exit();
    }
    else
    {
        require_once "$pathToFile";
    }
}

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
            requireFile('../app/Views/index.php');
            break;

        case 'add':
        case 'add.php':
            requireFile('../app/Views/add.php');
            break;

        case 'edit':
        case 'edit.php':
            requireFile('../app/Views/edit.php');
            break;

        case 'filter':
        case 'filter.php':
            requireFile('../app/Views/filter.php');
            break;

        case 'changepassword':
        case 'changepassword.php':
            requireFile('../app/Views/changepassword.php');
            break;
        
        case 'dashboard':
        case 'dashboard.php':
            requireFile('../app/Views/dashboard.php');
            break;

        case 'register':
        case 'register.php':
            requireFile('../app/Views/register.php');
            break;

        case 'login':
        case 'login.php':
            requireFile('../app/Views/login.php');
            break;

        case 'logout':
        case 'logout.php':
            requireFile('../app/Views/logout.php');
            break;

        case 'feedback':
        case 'feedback.php':
            requireFile('../app/Views/feedback.php');
            break;
        
        case 'docs':
        case 'docs.php':
            requireFile('../app/Views/docs.php');
            break;

        case 'sitemap':
        case 'sitemap.php':
            requireFile('../app/Views/sitemap.php');
            break;

        case 'show':
        case 'show.php':
            requireFile('../app/Views/show.php');
            break;

        case 'search':
        case 'search.php':
            requireFile('../app/Views/search.php');
            break;

        case 'get_user_contacts':
        case 'get_user_contacts.php':
            requireFile('../app/Models/get_user_contacts.php');
            break;

        case 'delete_user_contact':
        case 'delete_user_contact.php':
            requireFile('../app/Models/delete_user_contact.php');
            break;

        case 'get_particular_user_contact_data':
        case 'get_particular_user_contact_data.php':
            requireFile('../app/Models/get_particular_user_contact_data.php');
            break;

        /*
        case 'createusertable':
            requireFile('../app/Config/Database_Connection.php';
            break;
        */

        default:
            // Send 404 status header
            http_response_code(404);
            require_once '../app/Views/404.php';
            break;
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    switch($getPage)
    {
        case 'add_user_contact':
        case 'add_user_contact.php':
            requireFile('../app/Models/add_user_contact.php');
            break;

        case 'change_user_password':
        case 'change_user_password.php':
            requireFile('../app/Models/change_user_password.php');
            break;
        
        case 'edit_user_contact':
        case 'edit_user_contact.php':
            requireFile('../app/Models/edit_user_contact.php');
            break;

        case 'filter_user_contact':
        case 'filter_user_contact.php':
            requireFile('../app/Models/filter_user_contact.php');
            break;

        case 'get_user_data':
        case 'get_user_data.php':
            requireFile('../app/Models/get_user_data.php');
            break;

        case 'provide_feedback':
        case 'provide_feedback.php':
            requireFile('../app/Models/provide_feedback.php');
            break;

        case 'register_user_data':
        case 'register_user_data.php':
            requireFile('../app/Models/register_user_data.php');
            break;

        case 'search_user_contacts':
        case 'search_user_contacts.php':
            requireFile('../app/Models/search_user_contacts.php');
            break;

        default:
            // Send 404 status header
            http_response_code(404);
            require_once '../app/Views/404.php';
            break;
    }
}
?>
