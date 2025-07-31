<?php
header('Content-Type: application/json');

// Load prompt from POST
$data = json_decode(file_get_contents('php://input'), true);
$prompt = trim($data['prompt'] ?? '');

if ($prompt === '') {
    echo json_encode(["success" => false, "error" => "Prompt is empty"]);
    exit;
}

// Replace this with your actual Gemini API key from Google AI Studio
$apiKey = 'AIzaSyBUaaOSzdr6ylXePM51EfkL0T-JyjEzRRI';
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/chat-bison-001:generateMessage?key=$apiKey";

// Gemini v1beta only supports specific models like chat-bison-001 (NOT gemini-pro for free tier)
$postData = [
    "prompt" => [
        "messages" => [
            ["author" => "user", "content" => $prompt]
        ]
    ]
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(["success" => false, "error" => "Curl error: " . curl_error($ch)]);
    exit;
}

curl_close($ch);

$responseData = json_decode($response, true);

if ($httpCode === 200 && isset($responseData['candidates'][0]['content'])) {
    echo json_encode([
        "success" => true,
        "response" => $responseData['candidates'][0]['content']
    ]);
} else {
    $errorMsg = $responseData['error']['message'] ?? 'Unknown error';
    echo json_encode([
        "success" => false,
        "error" => "Gemini API error: " . $errorMsg
    ]);
}
