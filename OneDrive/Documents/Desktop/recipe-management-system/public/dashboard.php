<?php
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Auth.php';

$db = new Database();
$auth = new Auth($db);
if (!$auth->check()) header('Location: login.php');

$recipes = $db->pdo->query("SELECT r.id, title, name as category
                             FROM recipes r
                             JOIN categories c ON r.category_id=c.id
                             ORDER BY r.created_at DESC")
                      ->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Dashboard</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css"></head>
<body class="container pt-5">
  <div class="d-flex justify-content-between align-items-center">
    <h2>Your Recipes</h2>
    <div>
      <a href="logout.php" class="btn btn-warning">Logout</a>
      <a href="add_recipe.php" class="btn btn-success">Add Recipe</a>
    </div>
  </div>
  <table class="table table-striped mt-3">
    <thead><tr><th>Title</th><th>Category</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($recipes as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['title']) ?></td>
        <td><?= htmlspecialchars($r['category']) ?></td>
        <td>
          <a href="edit_recipe.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="delete_recipe.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
