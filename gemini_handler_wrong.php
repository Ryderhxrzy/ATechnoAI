<?php
require_once 'vendor/autoload.php';

use Google\GenerativeAI\GenerativeModel;

header('Content-Type: application/json');

$apiKey = 'YOUR_API_KEY';
$input = json_decode(file_get_contents("php://input"), true);
$prompt = $input['prompt'] ?? '';

if (!$prompt) {
    echo json_encode(['success' => false, 'error' => 'No prompt provided']);
    exit;
}

try {
    $model = new GenerativeModel('gemini-pro', [
        'apiKey' => $apiKey
    ]);
    $response = $model->generateContent($prompt);
    echo json_encode([
        'success' => true,
        'response' => $response->text()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Gemini API error: ' . $e->getMessage()
    ]);
}
?>
