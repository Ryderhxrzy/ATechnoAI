<?php
session_start();
ob_start(); // Start output buffering to prevent header errors
require_once '../vendor/autoload.php';

/* =============================================
   ENVIRONMENT CONFIGURATION
   ============================================= */
function loadConfig() {
    // 1. Get from Render environment variables
    $_ENV['GOOGLE_CLIENT_ID'] = getenv('GOOGLE_CLIENT_ID') ?: '';
    $_ENV['GOOGLE_CLIENT_SECRET'] = getenv('GOOGLE_CLIENT_SECRET') ?: '';
    
    // 2. Detect HTTPS (works on both Render and localhost)
    $isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    
    // 3. Build redirect URI (preserving your exact path structure)
    $_ENV['GOOGLE_REDIRECT_URI'] = ($isHttps ? 'https://' : 'http://') . 
                                   $_SERVER['HTTP_HOST'] . 
                                   '/google/authentication/auth_handler.php';
}

loadConfig();

/* =============================================
   DEBUG OUTPUT (Access with ?debug parameter)
   ============================================= */
if (isset($_GET['debug'])) {
    header('Content-Type: text/plain');
    echo "Current Configuration:\n";
    echo "CLIENT_ID: " . ($_ENV['GOOGLE_CLIENT_ID'] ?: 'NOT FOUND') . "\n";
    echo "REDIRECT_URI: " . ($_ENV['GOOGLE_REDIRECT_URI'] ?: 'NOT SET') . "\n";
    exit;
}

/* =============================================
   VALIDATION
   ============================================= */
$clientId = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
if (empty($clientId)) {
    die('Error: GOOGLE_CLIENT_ID not configured in Render Environment Variables');
}

/* =============================================
   GOOGLE CLIENT SETUP
   ============================================= */
$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET'] ?? '');
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI'] ?? '');
$client->addScope(['email', 'profile']);
$client->setAccessType('offline');
$client->setPrompt('select_account');

// Force HTTPS in production
if (strpos($_ENV['GOOGLE_REDIRECT_URI'] ?? '', 'https://') === 0) {
    $client->setHttpClient(new \GuzzleHttp\Client([
        'verify' => true,
        'timeout' => 15
    ]));
}

/* =============================================
   AUTHENTICATION HANDLERS (YOUR EXACT PATHS)
   ============================================= */

// Handle login request
if (isset($_GET['action']) && $_GET['action'] === 'google-login') {
    try {
        $authUrl = $client->createAuthUrl();
        header('Location: ' . $authUrl);
        ob_end_flush();
        exit;
    } catch (Exception $e) {
        $_SESSION['auth_error'] = 'Failed to create auth URL';
        header('Location: ../../index.php');
        ob_end_flush();
        exit;
    }
}

// Handle callback from Google
if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (isset($token['error'])) {
            throw new Exception($token['error_description'] ?? 'Invalid authorization code');
        }

        $client->setAccessToken($token);
        $oauth = new Google_Service_Oauth2($client);
        $userInfo = $oauth->userinfo->get();

        // Store user session
        $_SESSION['user'] = [
            'email' => $userInfo->email,
            'name' => $userInfo->name,
            'picture' => $userInfo->picture,
            'id' => $userInfo->id,
            'login_time' => time(),
            'login_method' => 'google'
        ];

        // Your exact original path
        header('Location: ../../users/home.php');
        ob_end_flush();
        exit;
        
    } catch (Exception $e) {
        $_SESSION['auth_error'] = 'Authentication failed';
        header('Location: ../../index.php');
        ob_end_flush();
        exit;
    }
}

// Handle errors
if (isset($_GET['error'])) {
    $_SESSION['auth_error'] = $_GET['error_description'] ?? 'Authentication cancelled';
    header('Location: ../../index.php');
    ob_end_flush();
    exit;
}

// Default fallback
header('Location: ../../index.php');
ob_end_flush();
exit;
?>