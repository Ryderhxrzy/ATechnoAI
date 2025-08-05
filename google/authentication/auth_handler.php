<?php
session_start();
ob_start();
require_once '../vendor/autoload.php';

/* =============================================
   DYNAMIC PATH CONFIGURATION
   ============================================= */
$current_dir = dirname($_SERVER['SCRIPT_NAME']); // Gets /google/authentication
$base_path = str_replace('/google/authentication', '', $current_dir);
$is_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
$_ENV['BASE_URL'] = ($is_https ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $base_path;

/* =============================================
   LOGOUT HANDLER (REDIRECTS TO INDEX.PHP)
   ============================================= */
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Complete session destruction
    $_SESSION = [];
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time()-3600, '/');
    
    // Redirect to index.php
    header('Location: ' . $_ENV['BASE_URL'] . '/index.php');
    ob_end_flush();
    exit;
}

/* =============================================
   GOOGLE AUTH INITIALIZATION
   ============================================= */
$client = new Google_Client();
$client->setClientId(getenv('GOOGLE_CLIENT_ID') ?: '');
$client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET') ?: '');
$client->setRedirectUri($_ENV['BASE_URL'] . '/google/authentication/auth_handler.php');
$client->addScope(['email', 'profile']);
$client->setAccessType('offline');
$client->setPrompt('select_account');

// Enable HTTPS verification in production
if ($is_https) {
    $client->setHttpClient(new \GuzzleHttp\Client([
        'verify' => true,
        'timeout' => 15
    ]));
}

/* =============================================
   AUTHENTICATION HANDLERS
   ============================================= */

// Handle Google login request
if (isset($_GET['action']) && $_GET['action'] === 'google-login') {
    try {
        $authUrl = $client->createAuthUrl();
        header('Location: ' . $authUrl);
        ob_end_flush();
        exit;
    } catch (Exception $e) {
        $_SESSION['auth_error'] = 'Failed to initialize login';
        header('Location: ' . $_ENV['BASE_URL'] . '/index.php');
        ob_end_flush();
        exit;
    }
}

// Handle Google callback
if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (isset($token['error'])) {
            throw new Exception($token['error_description'] ?? 'Invalid authorization code');
        }

        $client->setAccessToken($token);
        $oauth = new Google_Service_Oauth2($client);
        $userInfo = $oauth->userinfo->get();

        // Store user session data
        $_SESSION['user'] = [
            'email' => $userInfo->email,
            'name' => $userInfo->name,
            'picture' => $userInfo->picture,
            'id' => $userInfo->id,
            'login_time' => time(),
            'login_method' => 'google'
        ];

        // Redirect to home page
        header('Location: ' . $_ENV['BASE_URL'] . '/users/home.php');
        ob_end_flush();
        exit;
        
    } catch (Exception $e) {
        error_log('Google Auth Error: ' . $e->getMessage());
        $_SESSION['auth_error'] = 'Authentication failed. Please try again.';
        header('Location: ' . $_ENV['BASE_URL'] . '/index.php');
        ob_end_flush();
        exit;
    }
}

// Handle errors from Google
if (isset($_GET['error'])) {
    $_SESSION['auth_error'] = $_GET['error_description'] ?? 'Authentication cancelled';
    header('Location: ' . $_ENV['BASE_URL'] . '/index.php');
    ob_end_flush();
    exit;
}

// Default fallback redirect
header('Location: ' . $_ENV['BASE_URL'] . '/index.php');
ob_end_flush();
exit;
?>