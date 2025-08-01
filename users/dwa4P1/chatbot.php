<?php  
$api_key = "AIzaSyBlMS89USPZVtyF58UBBPXV_q5HEqDK2Tw";
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$api_key";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['message'])) {
    echo json_encode(['error'=> 'Invalid input']);
    exit;
}

$user_message = trim($input['message']);
$data = [
	"contents"=> [
		[
			"parts"=>[
				['text'=> $user_message]
			]
		]
	]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// ADD DEBUG INFO
if ($response === false) {
    echo json_encode(['error'=> 'cURL failed: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

if ($http_code !== 200) {
    echo json_encode(['error'=> 'API Error HTTP ' . $http_code . ': ' . $response]);
    exit;
}

$response_data = json_decode($response, true);

if(!isset($response_data['candidates'][0]['content']['parts'][0]['text'])){
    echo json_encode(['error'=> 'Unexpected API response: ' . json_encode($response_data)]);
    exit;
}

$ai_response = trim($response_data['candidates'][0]['content']['parts'][0]['text']);
echo json_encode(['response' => $ai_response]);
?>