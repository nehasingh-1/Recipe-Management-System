<?php
require_once __DIR__ . '/../includes/Database.php';
$db = new Database();

$where = [];
$params = [];
if (!empty($_GET['search'])) {
    $where[] = 'title LIKE ?';
    $params[] = '%' . $_GET['search'] . '%';
}
if (!empty($_GET['category'])) {
    $where[] = 'category_id = ?';
    $params[] = $_GET['category'];
}

$sql = "SELECT r.*, c.name AS cat_name FROM recipes r
        JOIN categories c ON r.category_id=c.id" .
        ($where ? ' WHERE ' . implode(' AND ', $where) : '') .
        ' ORDER BY r.created_at DESC';
$stmt = $db->pdo->prepare($sql);
$stmt->execute($params);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = $db->pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>All Recipes</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css"></head>
<body class="container pt-5">
  <h2>Recipes</h2>
  <form class="row mb-4" method="get">
    <div class="col"><input name="search" placeholder="Search title" class="form-control" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"></div>
    <div class="col"><select name="category" class="form-select"><option value="">All categories</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= (($_GET['category'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endforeach; ?>
    </select></div>
    <div class="col"><button class="btn btn-primary">Filter</button></div>
  </form>
  <div class="row">
    <?php foreach ($recipes as $r): ?>
    <div class="col-md-4">
      <div class="card mb-4">
        <div class="card-body">
          <h5><?= htmlspecialchars($r['title']) ?></h5>
          <p class="text-muted"><?= htmlspecialchars($r['cat_name']) ?></p>
          <a href="view_recipe.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
