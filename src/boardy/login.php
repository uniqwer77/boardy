<?php 
session_set_cookie_params([
    'lifetime' => 0,          
    'path'     => '/',
    'secure'   => false,    
    'httponly' => true,       
    'samesite' => 'Lax'      
]);

session_start();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare( 
        'SELECT id, name, password_hash FROM users WHERE email = ?' 
    ); 
    $stmt->execute([$email]); 
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) { 
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['user_name'] = $user['name'];

        header('Location: /messages.php'); 
        exit;
    } else {
        $error = "Неверный email или пароль";
    }
}
?>

<link rel="stylesheet" href="css/form.css">
<?php include __DIR__ . '/partials/head.php'; ?> 
<?php include __DIR__ . '/partials/nav.php'; ?>

<div class="login-container">
    <div class="login-card">
        <h1>Вход</h1>
        <?php if (!empty($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?= $error ?></div>
        <?php endif; ?>
        
        <form action="/login.php" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="ivan@example.com" required>
            </div>
            
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn-submit">Войти</button>
        </form>

        <div class="divider">
            <span>или</span>
        </div>

        <a href="/oauth-github.php" class="btn-github">
            <img src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" alt="GitHub Logo">
            Войти через GitHub
        </a>

        <div class="login-footer">
            Нет аккаунта? <a href="/register.php">Регистрация</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/foot.php'; ?>