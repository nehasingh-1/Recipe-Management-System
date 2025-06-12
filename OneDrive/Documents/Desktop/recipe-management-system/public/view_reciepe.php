<?php
require_once __DIR__.'/../includes/Database.php';
$db=new Database();

$id=$_GET['id'] ?? null;
if(!$id) header('Location: index.php');

$stmt=$db->pdo->prepare("SELECT r.*, c.name AS cat_name, u.username FROM recipes r
                         JOIN categories c ON r.category_id=c.id
                         JOIN users u ON r.user_id=u.id
                         WHERE r.id=?");
$stmt->execute([$id]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$r) header('Location: index.php');
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title><?=htmlspecialchars($r['title'])?></title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css"></head>
<body class="container pt-5">
  <a href="index.php" class="btn btn-secondary mb-3">Back to list</a>
  <h2><?=htmlspecialchars($r['title'])?></h2>
  <p><strong>Category:</strong> <?=htmlspecialchars($r['cat_name'])?></p>
  <p><strong>By:</strong> <?=htmlspecialchars($r['username'])?></p>
  <hr>
  <h4>Ingredients</h4>
  <p><?= nl2br(htmlspecialchars($r['ingredients'])) ?></p>
  <h4>Steps</h4>
  <p><?= nl2br(htmlspecialchars($r['steps'])) ?></p>
</body>
</html>
