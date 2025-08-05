<?php
session_start();
require_once '../vendor/autoload.php';

/* =============================================
   EXACT FILE STRUCTURE PRESERVATION
   - Keeps all your ../../ paths
   - Maintains .php extensions
   - Same redirect flow as original
   ============================================= */

/**
 * Environment loader that PRIORITIZES Render ENV variables
 * Falls back to .env file ONLY if not in production
 */
function loadConfig() {
    // First try to get from Render environment
    $_ENV['GOOGLE_CLIENT_ID'] = getenv('GOOGLE_CLIENT_ID') ?: '';
    $_ENV['GOOGLE_CLIENT_SECRET'] = getenv('GOOGLE_CLIENT_SECRET') ?: '';
    
    // Only check .env file if we're not in production
    if (!getenv('RENDER') && file_exists(__DIR__.'/../../.env')) {
        $lines = file(__DIR__.'/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");
                if (empty($_ENV[$key])) {
                    $_ENV[$key] = $value;
                }
            }
        }
    }
    
    // Auto-detect redirect URI (preserves your exact path structure)
    $_ENV['GOOGLE_REDIRECT_URI'] = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://')
        . $_SERVER['HTTP_HOST']
        . str_replace('/google/authentication/auth_handler.php', '', $_SERVER['SCRIPT_NAME'])
        . '/google/authentication/auth_handler.php';
}

loadConfig();

/* =============================================
   YOUR ORIGINAL VALIDATION LOGIC
   ============================================= */
$clientId = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'] ?? '';

if (empty($clientId)) {
    die('Error: GOOGLE_CLIENT_ID not configured');
}

/* =============================================
   YOUR EXACT ORIGINAL AUTH FLOW
   - Same ../../ paths
   - Same .php files
   - Same redirect behavior
   ============================================= */
$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope(['email', 'profile']);

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
    
    // YOUR EXACT ORIGINAL PATHS
    header('Location: ../../users/home.php');
    exit;
}

// YOUR EXACT ORIGINAL FALLBACK
header('Location: ../../index.php');
exit;
?>