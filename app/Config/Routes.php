<?php
declare(strict_types=1);

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
use App\Controllers\SessionController;
use App\Controllers\ErrorController;






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
$router->get("/", [HomeController::class, "index"]);


// For add page
$router->get("add", [AddController::class, "index"]);
// For add user contact
$router->post("add", [AddController::class, "add"]);


// For edit page
$router->get("edit", [EditController::class, "index"]);
// For edit user contact
$router->post("edit", [EditController::class, "edit"]);


// For filter page
$router->get("filter", [FilterController::class, "index"]);
// For filter user contact
$router->post("filter", [FilterController::class, "filter"]);


// For changepassword page
$router->get("change", [ChangeController::class, "index"]);
// For change user password
$router->post("change", [ChangeController::class, "change"]);



// For dashboard page
$router->get("dashboard", [DashboardController::class, "index"]);


// For register page
$router->get("register", [RegisterController::class, "index"]);
// For register user data
$router->post("register", [RegisterController::class, "register"]);





// For login page
$router->get("login", [LoginController::class, "index"]);
// For get user data
$router->post("login", [LoginController::class, "login"]);




// For logout page
$router->get("logout", [LogoutController::class, "index"]);
// For logout user
$router->post("logout", [LogoutController::class, "logout"]);




// For feedback page
$router->get("feedback", [FeedbackController::class, "index"]);
// For provide feedback
$router->post("feedback", [FeedbackController::class, "feedback"]);



// For docs page
$router->get("docs", [DocsController::class, "index"]);


// For sitemap page
$router->get("sitemap", [SitemapController::class, "index"]);



// For show page
$router->get("show", [ShowController::class, "index"]);
// For get_user_contacts page
$router->post("show", [ShowController::class, "show"]);



// For search page
$router->get("search", [SearchController::class, "index"]);
// For search user contacts
$router->post("search", [SearchController::class, "search"]);






// For delete_user_contact page
$router->get("delete", [UserController::class, "delete"]);


// For edit and search page
$router->get("single/{id:number}", [UserController::class, "single"]);


// For search page
$router->get("fields", [UserController::class, "fields"]);


// Testing the sessions
$router->get('/test-session', [SessionController::class, "test"]);
$router->get('/read-session', [SessionController::class, "read"]);

// $router->get('/test-session', function(ServerRequest $request):Response {
//     $_SESSION['test'] = "Hello Session";

//     return new Response(
//         200,
//         ['Content-Type' => 'text/plain'],
//         'Session value: ' . $_SESSION['test']
//     );
// });

// Reading the sessions
// $router->get("/read-session", function(ServerRequest $request):Response {
//     $value = $_SESSION['test'] ?? 'Session does not exist';

//     return new Response(
//         200,
//         ['Content-Type' => 'text/plain'],
//         $value
//     );
// });



// Check if the route exists for a particular request without executing the respective controller 
$result = $router->match($request);

if($result->isFound())
{
    $response = $router->dispatch($request);
}
else
{
    $response = (new ErrorController())->index();
}


// Matching routes to request.
// $response = $router->dispatch($request);

// Emitting or echoing response
$emitter = new SapiEmitter;
$emitter->emit($response);

?>
