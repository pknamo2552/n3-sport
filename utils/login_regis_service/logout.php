<?php
require __DIR__ . '/../../app/bootstrap.php'; // ต้องมี session_start() อยู่ในนี้แล้ว

$username = e($_SESSION['username'] ?? '');
$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $p = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

flash_add('success', 'ออกจากระบบ ไว้พบกันใหม่ ' . $username);
redirect_after_show_flash('/n3-sport/login.php', 5000, 'ออกจากระบบ', 'ไว้พบกันใหม่');
exit;
