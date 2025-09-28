<?php
require __DIR__ . '/../../app/bootstrap.php'; // ต้องมี session_start() อยู่ในนี้แล้ว

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . BASE_URL . 'login.php');
  exit;
}
$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $p = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

header('Location: ' . BASE_URL . 'login.php?logged_out=1');
exit;
