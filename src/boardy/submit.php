<?php
session_set_cookie_params([
    'lifetime' => 0,          
    'path'     => '/',
    'secure'   => true,    
    'httponly' => true,       
    'samesite' => 'Lax'      
]);

session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit; 
}

require_once 'db.php';
 
$userId = $_SESSION['user_id'];
$message = $_POST['body'] ?? '';
 
if ($message) {
    $stmt = $pdo->prepare(
        'INSERT INTO posts (body, author_id) VALUES (?, ?)'
    );
    $stmt->execute([$message, $userId]);
}
?>

<!DOCTYPE html>
<html lang="ru">
<
    <head><meta charset="utf-8"><title>Boardy</title>
    <link rel="stylesheet" href="/css/style.css"></head>
    <body>
        <header><h1><a href="/">Boardy</a></h1></header>
        <main>
            <h2>Спасибо, <?= htmlspecialchars($name) ?>!</h2>
            <p><a href="/index.php">На главную</a> |
                <a href="/messages.php">Все сообщения</a></p>
        </main>
    </body>
</html>