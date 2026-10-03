<?php


// define('BASE_URL', '/Projects/PHP/Contact_Manager/Website/public/');
// define('BASE_DIR', '/Projects/PHP/Contact_Manager/Website');



// Definition of requireFile() function
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



// Include composer autoloader
requireFile("../vendor/autoload.php");

// Include the session file
requireFile('../app/Views/sessionstart.php');




// Packages
use GuzzleHttp\Psr7\ServerRequest;
use League\Route\Router;
use HttpSoft\Emitter\SapiEmitter;


// Controllers
use App\Controllers\HomeController;
use App\Controllers\AddController;
use App\Controllers\EditController;
use App\Controllers\FilterController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\ChangeController;
use App\Controllers\DashboardController;
use App\Controllers\DocsController;
use App\Controllers\FeedbackController;
use App\Controllers\SearchController;
use App\Controllers\LogoutController;
use App\Controllers\SitemapController;
use App\Controllers\ShowController;
use App\Controllers\UserController;








// Creating the request object
$request = ServerRequest::fromGlobals();

// $path = $request->getUri()->getPath();
// echo $path;
// exit();

// Creating the router instance
$router = new Router;


// Defining routes

// GET REQUESTS


// For homepage
// $router->get("index", [HomeController::class, "index"]);
// $router->get("", [HomeController::class, "index"]);
// $router->get("home", [HomeController::class, "index"]);
$router->get("/", [HomeController::class, "index"]);
// $router->get("index.php", [HomeController::class, "index"]);
// $router->get("home.php", [HomeController::class, "index"]);


// For add page
$router->get("add", [AddController::class, "index"]);
// For add user contact
// $router->post("add_user_contact", [AddController::class, "add"]);
$router->post("add", [AddController::class, "add"]);


// For edit page
$router->get("edit", [EditController::class, "index"]);
// For edit user contact
// $router->post("edit_user_contact", [EditController::class, "edit"]);
$router->post("edit", [EditController::class, "edit"]);


// For filter page
$router->get("filter", [FilterController::class, "index"]);
// For filter user contact
// $router->post("filter_user_contact", [FilterController::class, "filter"]);
$router->post("filter", [FilterController::class, "filter"]);


// For changepassword page
// $router->get("changepassword", [ChangePasswordController::class, "index"]);
$router->get("change", [ChangeController::class, "index"]);
// For change user password
// $router->post("change_user_password", [ChangePasswordController::class, "change"]);
$router->post("change", [ChangeController::class, "change"]);



// For dashboard page
$router->get("dashboard", [DashboardController::class, "index"]);


// For register page
$router->get("register", [RegisterController::class, "index"]);
// For register user data
// $router->post("register_user_data", [RegisterController::class, "register"]);
$router->post("register", [RegisterController::class, "register"]);





// For login page
$router->get("login", [LoginController::class, "index"]);
// For get user data
// $router->post("get_user_data", [LoginController::class, "login"]);
$router->post("login", [LoginController::class, "login"]);




// For logout page
$router->get("logout", [LogoutController::class, "index"]);
// For logout user
// $router->post("logout_user", [LogoutController::class, "logout"]);
$router->post("logout", [LogoutController::class, "logout"]);




// For feedback page
$router->get("feedback", [FeedbackController::class, "index"]);
// For provide feedback
// $router->post("provide_feedback", [FeedbackController::class, "feedback"]);
$router->post("feedback", [FeedbackController::class, "feedback"]);



// For docs page
$router->get("docs", [DocsController::class, "index"]);


// For sitemap page
$router->get("sitemap", [SitemapController::class, "index"]);



// For show page
$router->get("show", [ShowController::class, "index"]);
// For get_user_contacts page
// $router->get("get_user_contacts", [ShowController::class, "show"]);
$router->post("show", [ShowController::class, "show"]);



// For search page
$router->get("search", [SearchController::class, "index"]);
// For search user contacts
// $router->post("search_user_contacts", [SearchController::class, "search"]);
$router->post("search", [SearchController::class, "search"]);






// For delete_user_contact page
// $router->get("delete_user_contact", [UserController::class, "delete"]);
$router->get("delete", [UserController::class, "delete"]);


// For search page
// $router->get("get_particular_user_contact_data", [UserController::class, "single"]);
$router->get("single", [UserController::class, "single"]);


// For search page
// $router->get("get_additional_fields", [UserController::class, "fields"]);
$router->get("fields", [UserController::class, "fields"]);




// Matching routes to request.
$response = $router->dispatch($request);

// Emitting or echoing response
$emitter = new SapiEmitter;
$emitter->emit($response);




// $getURL = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'index';
// //echo $getURL;

// $get_url_parts = explode('/', $getURL);
// $getPage = $get_url_parts[0];

/*
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

        case 'get_additional_fields':
        case 'get_additional_fields.php':
            requireFile('../app/Models/get_additional_fields.php');
            break;

        
        case 'createusertable':
            requireFile('../app/Config/Database_Connection.php';
            break;
        

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

        case 'logout_user':
        case 'logout_user.php':
            requireFile('../app/Models/logout_user.php');
            break;

        default:
            // Send 404 status header
            http_response_code(404);
            require_once '../app/Views/404.php';
            break;
    }
}
*/
?>
