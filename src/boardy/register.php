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
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)){
        $error = "Все поля должны быть заполнены";
    }  elseif (strlen($password) < 6) {        
        $error = "Пароль должен быть не менее 6 символов";
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?'); 
        $stmt->execute([$email]); 
        if ($stmt->fetch()) { 
            $error = "Пользователь с таким email уже зарегистрирован";
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare( 
                'INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)' 
            ); 
            $stmt->execute([$name, $email, $hash]); 
            $new_id = $pdo->lastInsertId();

            $_SESSION['user_id'] = $new_id; 
            $_SESSION['user_name'] = $name; 
            header('Location: /messages.php'); 
            exit;
        }
    } 
}
?>

<?php include __DIR__ . '/partials/head.php'; ?> 
<?php include __DIR__ . '/partials/nav.php'; ?>

<link rel="stylesheet" href="css/form.css">
<div class="login-container">
    <div class="login-card">
        <h1>Регистрация</h1>
        <?php if (!empty($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?= $error ?></div>
        <?php endif; ?>
        
        <form action="/register.php" method="POST">
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" placeholder="Иванов Иван" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="ivan@example.com" required>
            </div>
            
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn-submit">Зарегистрироваться</button>
        </form>

        <div class="login-footer">
            Уже есть аккаунт? <a href="/login.php">Войти</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/foot.php'; ?>