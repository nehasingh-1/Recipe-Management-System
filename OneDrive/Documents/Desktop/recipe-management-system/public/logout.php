<?php
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Auth.php';
$db = new Database();
$auth = new Auth($db);
$auth->logout();
