<?php
require_once __DIR__.'/../includes/Database.php';
require_once __DIR__.'/../includes/Auth.php';
$db=new Database(); $auth=new Auth($db);
if(!$auth->check()) header('Location: login.php');

$cats=$db->pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

$rId=$_GET['id'] ?? null;
if(!$rId) header('Location: dashboard.php');

$stmt=$db->pdo->prepare("SELECT * FROM recipes WHERE id=?");
$stmt->execute([$rId]);
$r=$stmt->fetch(PDO::FETCH_ASSOC);
if(!$r) header('Location: dashboard.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $stmt=$db->pdo->prepare("UPDATE recipes SET category_id=?, title=?, ingredients=?, steps=? WHERE id=?");
    $stmt->execute([$_POST['category'], $_POST['title'], $_POST['ingredients'], $_POST['steps'], $rId]);
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Edit Recipe</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css"></head>
<body class="container pt-5">
  <h2>Edit Recipe</h2>
  <form method="post">
    <div class="mb-3"><label>Category</label>
      <select name="category" class="form-select" required>
        <?php foreach($cats as $c):?>
          <option value="<?=$c['id']?>" <?=($c['id']==$r['category_id'])?'selected':''?>><?=htmlspecialchars($c['name'])?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3"><label>Title</label><input name="title" class="form-control" required value="<?=htmlspecialchars($r['title'])?>"></div>
    <div class="mb-3"><label>Ingredients</label><textarea name="ingredients" class="form-control" required><?=htmlspecialchars($r['ingredients'])?></textarea></div>
    <div class="mb-3"><label>Steps</label><textarea name="steps" class="form-control" required><?=htmlspecialchars($r['steps'])?></textarea></div>
    <button class="btn btn-primary">Update</button>
  </form>
</body>
</html>
