<?php
session_start();
require_once '../vendor/autoload.php';

// Simple .env file loader function
function loadEnvironmentVariables($path) {
    if (!file_exists($path)) {
        throw new Exception('.env file not found at: ' . $path);
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments and empty lines
        if (strpos(trim($line), '#') === 0 || empty(trim($line))) {
            continue;
        }
        
        // Parse key=value pairs
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            $value = trim($value, '"\'');
            
            // Set environment variable
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }
}

try {
    // Load environment variables from .env file (2 levels up from current directory)
    loadEnvironmentVariables('../../.env');
} catch (Exception $e) {
    die('Configuration Error: ' . $e->getMessage() . '<br>Please make sure your .env file exists in the project root directory.');
}

// Get configuration from environment variables
$clientId = getenv('GOOGLE_CLIENT_ID') ?: ($_ENV['GOOGLE_CLIENT_ID'] ?? '');
$clientSecret = getenv('GOOGLE_CLIENT_SECRET') ?: ($_ENV['GOOGLE_CLIENT_SECRET'] ?? '');
$redirectUri = getenv('GOOGLE_REDIRECT_URI') ?: ($_ENV['GOOGLE_REDIRECT_URI'] ?? '');

// Validate configuration
if (empty($clientId)) {
    die('Error: GOOGLE_CLIENT_ID not found in environment variables. Please check your .env file.');
}
if (empty($clientSecret)) {
    die('Error: GOOGLE_CLIENT_SECRET not found in environment variables. Please check your .env file.');
}
if (empty($redirectUri)) {
    die('Error: GOOGLE_REDIRECT_URI not found in environment variables. Please check your .env file.');
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
} catch (Exception $e) {
    die('Google Client Error: ' . $e->getMessage());
}

// Handle the initial Google login request
if (isset($_GET['action']) && $_GET['action'] === 'google-login') {
    try {
        $authUrl = $client->createAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    } catch (Exception $e) {
        $_SESSION['auth_error'] = 'Failed to create Google authorization URL: ' . $e->getMessage();
        header('Location: ../../login.php');
        exit;
    }
}

// Handle the callback from Google
if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (isset($token['error'])) {
            throw new Exception($token['error_description'] ?? 'Authentication failed');
        }

        $client->setAccessToken($token);
        $oauth = new Google_Service_Oauth2($client);
        $userInfo = $oauth->userinfo->get();

        // Store user information in session
        $_SESSION['user'] = [
            'email' => $userInfo->email,
            'name' => $userInfo->name,
            'picture' => $userInfo->picture,
            'id' => $userInfo->id,
            'login_time' => time(),
            'login_method' => 'google'
        ];

        // Clear any previous auth errors
        unset($_SESSION['auth_error']);

        // Redirect to welcome page
        header('Location: ../../users/index.php');
        exit;
        
    } catch (Exception $e) {
        error_log('Google OAuth Error: ' . $e->getMessage());
        $_SESSION['auth_error'] = 'Authentication failed: ' . $e->getMessage();
        header('Location: ../../login.php');
        exit;
    }
}

// Handle error cases (user cancelled, etc.)
if (isset($_GET['error'])) {
    $error_description = $_GET['error_description'] ?? 'Authentication was cancelled or failed.';
    $_SESSION['auth_error'] = $error_description;
    header('Location: ../../login.php');
    exit;
}

// If we reach here without valid parameters, redirect to login
$_SESSION['auth_error'] = 'Invalid authentication request.';
header('Location: ../../login.php');
exit;
?>