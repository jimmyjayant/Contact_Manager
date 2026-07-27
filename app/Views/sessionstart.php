<?php
// set cookie params FIRST
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false, // false = HTTP, true = HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);

// This PHP configuration directive forces to use session id supplied via cookies to the web server AND not via url.
ini_set('session.use_only_cookies', '1');

/* This PHP configuration directive forces to reject random session ids supplied via user to web server. And re-initialize one if the provided one is not on server. */
ini_set('session.use_strict_mode', '1');

if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}


// Update the current session id with a new one which is more stronger
session_regenerate_id(true);

// If session array key 'csrf_token' does not exist, then
if(!isset($_SESSION['csrf_token']))
{
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// If the session variable 'last_activity' is set, then
if(isset($_SESSION['last_activity']))
{
    if(time() - $_SESSION['last_activity'] > 600)
    {
        header("Location: logout");
        exit();
    }
}
else
{
    $_SESSION['last_activity'] = time();
}
?>
