<?php
require_once __DIR__.'/../includes/Database.php';
require_once __DIR__.'/../includes/Auth.php';
$db=new Database();
$auth=new Auth($db);
if(!$auth->check()) header('Location: login.php');

$cats=$db->pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $stmt=$db->pdo->prepare("INSERT INTO recipes (user_id, category_id, title, ingredients, steps) VALUES (?,?,?,?,?)");
    $stmt->execute([$_SESSION['user_id'], $_POST['category'], $_POST['title'], $_POST['ingredients'], $_POST['steps']]);
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Add Recipe</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css"></head>
<body class="container pt-5">
  <h2>Add Recipe</h2>
  <?php if($error):?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3"><label>Category</label>
      <select name="category" class="form-select" required>
        <?php foreach($cats as $c):?><option value="<?=$c['id']?>"><?=htmlspecialchars($c['name'])?></option><?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3"><label>Title</label><input name="title" class="form-control" required></div>
    <div class="mb-3"><label>Ingredients</label><textarea name="ingredients" class="form-control" required></textarea></div>
    <div class="mb-3"><label>Steps</label><textarea name="steps" class="form-control" required></textarea></div>
    <button class="btn btn-success">Save</button>
  </form>
</body>
</html>
