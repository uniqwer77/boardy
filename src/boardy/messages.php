<?php
session_set_cookie_params([
    'lifetime' => 0,          
    'path'     => '/',
    'secure'   => true,    
    'httponly' => true,       
    'samesite' => 'Lax'      
]);

session_start();

require_once 'db.php';

$stmt = $pdo->query(
  'SELECT posts.body, users.name, posts.created_at
  FROM posts
  JOIN users ON posts.author_id = users.id
  ORDER BY posts.created_at DESC'
);
$messages = $stmt->fetchAll();
?>
<link rel="stylesheet" href="css/messages.css">
<?php include __DIR__ . '/partials/head.php'; ?>
<?php include __DIR__ . '/partials/nav.php'; ?>

<main>
  <div class="posts-container">
    <h1 class="posts-header">Все посты</h1>

    <?php if (empty($messages)): ?>
    <p>Постов пока нет.</p>
    <?php else: ?>
    <?php foreach ($messages as $msg): ?>
    <div class="post-card">
      <span class="post-author"><?= htmlspecialchars($msg['name']) ?></span>
      <span class="post-date"><?= htmlspecialchars($msg['created_at']) ?></span>
      <div class="post-body">
        <?= nl2br(htmlspecialchars($msg['body'])) ?>
      </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>

</main>

<?php include __DIR__ . '/partials/foot.php'; ?>