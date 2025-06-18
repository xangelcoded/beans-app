<?php
// pages/logout.php
require __DIR__ . '/../init.php';  // this already starts the session for us

// 1) Clear all session data
$_SESSION = [];

// 2) Destroy the session cookie, if one exists
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// 3) Finally destroy the session
session_destroy();

// 4) Redirect back to the login page
header('Location: ../login.php');
exit;
