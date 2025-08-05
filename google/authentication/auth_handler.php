<?php
session_start();
require_once '../vendor/autoload.php';

// =============================================
// ENVIRONMENT CONFIGURATION (PRODUCTION-READY)
// =============================================
function loadConfig() {
    // 1. First try to get from Render environment
    $_ENV['GOOGLE_CLIENT_ID'] = getenv('GOOGLE_CLIENT_ID');
    $_ENV['GOOGLE_CLIENT_SECRET'] = getenv('GOOGLE_CLIENT_SECRET');
    
    // 2. If not in Render, check .env file (for local development)
    if (empty($_ENV['GOOGLE_CLIENT_ID']) && file_exists(__DIR__.'/../../.env')) {
        $lines = file(__DIR__.'/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");
                $_ENV[$key] = $value;
            }
        }
    }
    
    // 3. Auto-detect redirect URI (preserves your exact path structure)
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    $baseUrl = $protocol . $_SERVER['HTTP_HOST'];
    $scriptPath = str_replace('/google/authentication/auth_handler.php', '', $_SERVER['SCRIPT_NAME']);
    $_ENV['GOOGLE_REDIRECT_URI'] = $baseUrl . $scriptPath . '/google/authentication/auth_handler.php';
}

loadConfig();

// =============================================
// DEBUGGING OUTPUT (TEMPORARY)
// =============================================
echo '<pre>';
echo 'Current Configuration:'."\n";
echo 'CLIENT_ID: '.($_ENV['GOOGLE_CLIENT_ID'] ?? 'NOT FOUND')."\n";
echo 'REDIRECT_URI: '.($_ENV['GOOGLE_REDIRECT_URI'] ?? 'NOT SET')."\n";
echo '</pre>';

// =============================================
// VALIDATION (YOUR EXACT REQUIREMENTS)
// =============================================
$clientId = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
if (empty($clientId)) {
    die('Error: GOOGLE_CLIENT_ID not configured. Check Render Environment Variables or .env file');
}

$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'] ?? '';

// =============================================
// GOOGLE CLIENT INIT (PRESERVING YOUR PATHS)
// =============================================
$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope(['email', 'profile']);
$client->setAccessType('offline');

// =============================================
// YOUR ORIGINAL AUTH FLOW (UNCHANGED PATHS)
// =============================================
if (isset($_GET['action']) && $_GET['action'] === 'google-login') {
    header('Location: ' . $client->createAuthUrl());
    exit;
}

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);
    
    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();
    
    $_SESSION['user'] = [
        'email' => $userInfo->email,
        'name' => $userInfo->name,
        'picture' => $userInfo->picture,
        'id' => $userInfo->id
    ];
    
    // YOUR EXACT PATH STRUCTURE
    header('Location: ../../users/home.php');
    exit;
}

// YOUR EXACT FALLBACK PATH
header('Location: ../../index.php');
exit;
?>