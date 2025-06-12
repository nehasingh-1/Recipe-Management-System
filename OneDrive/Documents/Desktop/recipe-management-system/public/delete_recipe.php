<?php
require_once __DIR__.'/../includes/Database.php';
require_once __DIR__.'/../includes/Auth.php';
$db=new Database(); $auth=new Auth($db);
if(!$auth->check()) header('Location: login.php');

$rId=$_GET['id'] ?? null;
if($rId) {
    $stmt=$db->pdo->prepare("DELETE FROM recipes WHERE id=?");
    $stmt->execute([$rId]);
}
header('Location: dashboard.php');
exit;
