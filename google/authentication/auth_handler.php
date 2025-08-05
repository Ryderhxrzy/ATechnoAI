<?php
session_start();
require_once '../vendor/autoload.php';

/**
 * Environment Configuration Loader
 * Direktang kumukuha ng values mula sa environment variables
 */
function loadConfig() {
    // Direktang iload ang mga required variables
    $_ENV['GOOGLE_CLIENT_ID'] = getenv('GOOGLE_CLIENT_ID') ?: '';
    $_ENV['GOOGLE_CLIENT_SECRET'] = getenv('GOOGLE_CLIENT_SECRET') ?: '';
    $_ENV['GOOGLE_REDIRECT_URI'] = getenv('GOOGLE_REDIRECT_URI') ?: '';
    
    // Debugging - ito ay dapat tanggalin sa production
    if (getenv('APP_DEBUG') === 'true') {
        echo "<pre>Environment Variables:\n";
        echo "GOOGLE_CLIENT_ID: " . (empty($_ENV['GOOGLE_CLIENT_ID']) ? 'MISSING' : 'SET') . "\n";
        echo "GOOGLE_CLIENT_SECRET: " . (empty($_ENV['GOOGLE_CLIENT_SECRET']) ? 'MISSING' : 'SET') . "\n";
        echo "GOOGLE_REDIRECT_URI: " . (empty($_ENV['GOOGLE_REDIRECT_URI']) ? 'MISSING' : 'SET') . "\n";
        echo "</pre>";
    }
}

// Load configuration
loadConfig();

// Get configuration from environment variables
$clientId = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'] ?? '';

// Validate configuration
if (empty($clientId)) {
    die('Error: GOOGLE_CLIENT_ID not configured. Please set it in Render Environment Group');
}
if (empty($clientSecret)) {
    die('Error: GOOGLE_CLIENT_SECRET not configured in Environment Group');
}
if (empty($redirectUri)) {
    die('Error: GOOGLE_REDIRECT_URI not configured in Environment Group');
}

// Initialize Google Client
try {
    $client = new Google_Client();
    $client->setClientId($clientId);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->addScope(['email', 'profile']);
    $client->setAccessType('offline');
    $client->setPrompt('select_account');
    
    // For production, enforce HTTPS
    if (getenv('RENDER')) {
        $client->setHttpClient(new \GuzzleHttp\Client([
            'verify' => true, // Enable SSL verification
            'timeout' => 15
        ]));
    }
} catch (Exception $e) {
    die('Google Client Error: ' . $e->getMessage());
}

// Handle Google login request
if (isset($_GET['action']) && $_GET['action'] === 'google-login') {
    try {
        $authUrl = $client->createAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    } catch (Exception $e) {
        $_SESSION['auth_error'] = 'Failed to create auth URL: ' . $e->getMessage();
        header('Location: ../../index.php');
        exit;
    }
}

// Handle Google callback
if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (isset($token['error'])) {
            throw new Exception($token['error_description'] ?? 'Authentication failed');
        }

        $client->setAccessToken($token);
        $oauth = new Google_Service_Oauth2($client);
        $userInfo = $oauth->userinfo->get();

        // Store user information
        $_SESSION['user'] = [
            'email' => $userInfo->email,
            'name' => $userInfo->name,
            'picture' => $userInfo->picture,
            'id' => $userInfo->id,
            'login_time' => time(),
            'login_method' => 'google'
        ];

        header('Location: ../../users/home.php');
        exit;
        
    } catch (Exception $e) {
        error_log('Google Auth Error: ' . $e->getMessage());
        $_SESSION['auth_error'] = 'Authentication failed. Please try again.';
        header('Location: ../../index.php');
        exit;
    }
}

// Handle errors
if (isset($_GET['error'])) {
    $_SESSION['auth_error'] = $_GET['error_description'] ?? 'Authentication cancelled';
    header('Location: ../../index.php');
    exit;
}

// Default redirect
$_SESSION['auth_error'] = 'Invalid request';
header('Location: ../../index.php');
exit;
?>