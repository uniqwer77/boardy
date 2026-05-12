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
?>

<link rel="stylesheet" href="css/feedback.css">
<?php include __DIR__ . '/partials/head.php'; ?> 
<?php include __DIR__ . '/partials/nav.php'; ?>


<main class="submit-container">
    <div class="submit-card">
        <h1>Новый пост</h1>
        
        <form action="/submit.php" method="POST">
            <div class="form-group">
                <label for="post_text">Текст</label>
                <textarea 
                    name="body" 
                    id="post_text" 
                    placeholder="Напишите ваше объявление..." 
                    required
                ></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Опубликовать</button>
                <a href="/messages.php" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/partials/foot.php'; ?>