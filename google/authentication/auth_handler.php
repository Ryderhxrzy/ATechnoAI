<?php
session_start();
ob_start();
require_once '../vendor/autoload.php';

/* =============================================
   ENVIRONMENT DETECTION
   ============================================= */
define('IS_PRODUCTION', getenv('RENDER') !== false);
define('IS_LOCAL', !IS_PRODUCTION && in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));

/* =============================================
   CONFIGURATION LOADER
   ============================================= */
function loadConfig() {
    $config = [
        'client_id' => getenv('GOOGLE_CLIENT_ID'),
        'client_secret' => getenv('GOOGLE_CLIENT_SECRET')
    ];

    // Fallback to .env file for local development
    if (IS_LOCAL && file_exists(__DIR__.'/../../.env')) {
        $env = parse_ini_file(__DIR__.'/../../.env');
        $config['client_id'] = $config['client_id'] ?: $env['GOOGLE_CLIENT_ID'] ?? '';
        $config['client_secret'] = $config['client_secret'] ?: $env['GOOGLE_CLIENT_SECRET'] ?? '';
    }

    // Auto-detect base URL
    $is_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    $config['base_url'] = ($is_https ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . 
                         str_replace('/google/authentication', '', dirname($_SERVER['SCRIPT_NAME']));

    return $config;
}

$config = loadConfig();

/* =============================================
   GOOGLE CLIENT SETUP
   ============================================= */
$client = new Google_Client();
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['base_url'] . '/google/authentication/auth_handler.php');
$client->addScope(['email', 'profile']);
$client->setAccessType('offline');
$client->setPrompt('select_account');

// HTTPS settings
if (IS_PRODUCTION) {
    $client->setHttpClient(new \GuzzleHttp\Client([
        'verify' => true,
        'timeout' => 15
    ]));
} else {
    $client->setHttpClient(new \GuzzleHttp\Client([
        'verify' => false,
        'timeout' => 10
    ]));
}

/* =============================================
   AUTHENTICATION HANDLERS
   ============================================= */
try {
    // Logout Handler
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time()-3600, '/');
        header('Location: ' . $config['base_url'] . '/index.php');
        exit;
    }

    // Login Initiation
    if (isset($_GET['action']) && $_GET['action'] === 'google-login') {
        header('Location: ' . $client->createAuthUrl());
        exit;
    }

    // Callback Handler
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (isset($token['error'])) {
            throw new Exception($token['error_description'] ?? 'Invalid authorization code');
        }

        $client->setAccessToken($token);
        $oauth = new Google_Service_Oauth2($client);
        $userInfo = $oauth->userinfo->get();

        // COMPLETE SESSION DATA WITH LOGIN TIME AND METHOD
        $_SESSION['user'] = [
            'email' => $userInfo->email,
            'name' => $userInfo->name,
            'picture' => $userInfo->picture,
            'id' => $userInfo->id,
            'login_time' => time(),                     // ADDED BACK
            'login_method' => 'google'                 // ADDED BACK
        ];

        header('Location: ' . $config['base_url'] . '/users/home.php');
        exit;
    }
} catch (Exception $e) {
    error_log('Auth Error: ' . $e->getMessage());
    $_SESSION['auth_error'] = IS_PRODUCTION 
        ? 'System temporarily unavailable' 
        : 'Error: ' . $e->getMessage();
}

// Fallback redirect
header('Location: ' . $config['base_url'] . '/index.php');
ob_end_flush();
?>