<?php
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Auth.php';

$db = new Database();
$auth = new Auth($db);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$auth->login($_POST['username'], $_POST['password'])) {
        $error = 'Invalid credentials';
    } else {
        header('Location: dashboard.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Login</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="container pt-5">
  <h2>Login</h2>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-3"><label>Username</label><input name="username" class="form-control" required></div>
    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
    <button class="btn btn-primary">Login</button>
  </form>
</body>
</html>
