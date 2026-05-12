<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require 'db.php';

if (($_GET['state'] ?? '') !== ($_SESSION['oauth_state'] ?? '')) {
    die('Invalid state — possible CSRF attack'); 
}


// Паттерн: сервер→сервер (back-channel)
// Браузер не участвует. client_secret не виден пользователю.
$ch = curl_init('https://github.com/login/oauth/access_token');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'client_id' => 'Ov23liP55hHA4V62vrbB',
        'client_secret' => 'a0812cc86fbd7af5d16e26ba64ea012d411f0973',
        'code' => $_GET['code'],
    ]),
    CURLOPT_HTTPHEADER => ['Accept: application/json'],
    CURLOPT_RETURNTRANSFER => true,
]);

$response = json_decode(curl_exec($ch), true);
curl_close($ch);

$access_token = $response['access_token'];


// Паттерн: с access_token запросить данные у провайдера
$ch = curl_init('https://api.github.com/user');

curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $access_token",
        'User-Agent: Boardy'
    ],
    CURLOPT_RETURNTRANSFER => true,
]);

$profile = json_decode(curl_exec($ch), true);
curl_close($ch);


// Паттерн: SELECT по внешнему ID. Нет → INSERT.
$stmt = $pdo->prepare('SELECT id, name FROM users WHERE github_id = ?');
$stmt->execute([$profile['id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $stmt = $pdo->prepare('INSERT INTO users (name, github_id) VALUES (?, ?)');
    $stmt->execute([$profile['login'], $profile['id']]);
    
    $user = [
        'id' => $pdo->lastInsertId(),
        'name' => $profile['login']
    ];
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['is_github_user'] = true;

header('Location: /messages.php');
exit;
