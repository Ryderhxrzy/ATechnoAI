<?php
session_start();
require_once '../vendor/autoload.php';

// 1. ENVIRONMENT CONFIG (PRODUCTION-READY)
function loadConfig() {
    // Priority 1: Render Environment Variables
    $_ENV['GOOGLE_CLIENT_ID'] = getenv('GOOGLE_CLIENT_ID') ?: '';
    $_ENV['GOOGLE_CLIENT_SECRET'] = getenv('GOOGLE_CLIENT_SECRET') ?: '';
    
    // Priority 2: Auto-detect current URL (preserves your paths)
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $current_path = dirname(dirname($_SERVER['SCRIPT_NAME'])); // Preserves ../../
    $_ENV['GOOGLE_REDIRECT_URI'] = $protocol . $_SERVER['HTTP_HOST'] . $current_path . '/google/authentication/auth_handler.php';
}

loadConfig();

// 2. YOUR EXACT PATH STRUCTURE
$clientId = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'] ?? '';

// 3. INIT CLIENT (PRESERVED YOUR PATHS)
$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri); 
$client->addScope(['email', 'profile']);

// 4. YOUR ORIGINAL AUTH FLOW (UNCHANGED)
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
        'picture' => $userInfo->picture
    ];
    
    header('Location: ../../users/home.php'); // YOUR EXACT PATH
    exit;
}

header('Location: ../../index.php'); // YOUR EXACT PATH
exit;
?>