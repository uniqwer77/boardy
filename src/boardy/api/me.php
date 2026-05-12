<?php
// Паттерн: по куке PHPSESSID вернуть JWT
// React вызывает этот endpoint при загрузке

session_set_cookie_params([
    'lifetime' => 0,          
    'path'     => '/',
    'secure'   => false,    
    'httponly' => true,       
    'samesite' => 'Lax'      
]);

session_start();

$secret_key = 'secret-key';

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

// Генерация JWT
function generate_jwt($user_id, $user_name, $secret_key) {
    $header = rtrim(strtr(base64_encode(json_encode([
        'alg' => 'HS256',
        'typ' => 'JWT'
    ])), '+/', '-_'), '=');

    $payload = rtrim(strtr(base64_encode(json_encode([
        'user_id' => $user_id,
        'name'    => $user_name,
        'exp'     => time() + 3600 // Токен протухнет через 1 час
    ])), '+/', '-_'), '=');

    $signature = rtrim(strtr(base64_encode(
        hash_hmac('sha256', "$header.$payload", $secret_key, true)
    ), '+/', '-_'), '=');

    return "$header.$payload.$signature";
}

$jwt = generate_jwt($_SESSION['user_id'], $_SESSION['user_name'], $secret_key);

header('Content-Type: application/json');
echo json_encode(['token' => $jwt]);
