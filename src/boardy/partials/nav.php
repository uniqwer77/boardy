<?php
    $is_logged = !empty($_SESSION['user_id']);
    $user_name = $_SESSION['user_name'] ?? '';

    $current_page = $_SERVER['SCRIPT_NAME'];

    function isActive($path, $current_page) {
        return $path === $current_page ? 'class="active"' : '';
    }
?>

<link rel="stylesheet" href="css/nav.css">
<nav>
    <div class="nav-left">
        <a href="/index.php" class="brand">Boardy</a>
        <a href="/messages.php" <?= isActive('/messages.php', $current_page) ?>>Все посты</a>
        <?php if ($is_logged): ?>
            <a href="/feedback.php" <?= isActive('/feedback.php', $current_page) ?>>Добавить пост</a>
    </div>

    <div class="nav-right">
            <span>Привет, <?= htmlspecialchars($user_name) ?>!</span>
            <a href="/logout.php">Выйти</a>
        <?php else: ?>
            <a href="/login.php" <?= isActive('/login.php', $current_page) ?>>Вход</a>
            <a href="/register.php" <?= isActive('/register.php', $current_page) ?>>Регистрация</a>
        <?php endif; ?>
    </div>
</nav>
