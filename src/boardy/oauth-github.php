// Паттерн: перенаправить пользователя на OAuth-провайдер
<?php
session_start();

$state = bin2hex(random_bytes(16));
$_SESSION['oauth_state'] = $state;

$params = http_build_query([
    'client_id' => 'Ov23liP55hHA4V62vrbB',
    'redirect_uri' => 'http://tlop.ai-info.ru/oauth-callback.php',
    'scope' => 'read:user',
    'state' => $state,
]);

header("Location: https://github.com/login/oauth/authorize?$params");
exit;
