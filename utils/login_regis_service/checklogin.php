<?php
// utils/checklogin.php
require __DIR__ . '/../../app/db.php';
require __DIR__ . '/../../app/helpers.php';
session_start();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
  flash_add('danger', 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน');
  header('Location: /n3-sport/login.php'); exit;
}

$mysqli = db();
$stmt = $mysqli->prepare("SELECT id, username, name, email, phone, password FROM users WHERE username=? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($user && $password === $user['password']) {
  // set session
  $_SESSION['username'] = $user['username'];
  $_SESSION['name']     = $user['name'];
  $_SESSION['email']    = $user['email'];
  $_SESSION['phone']    = $user['phone'];
  $_SESSION['status']   = 'online';

  flash_add('success', 'เข้าสู่ระบบสำเร็จ ยินดีต้อนรับ ' . $user['name']);
  redirect_after_show_flash('/n3-sport/index.php', 5000, 'เข้าสู่ระบบสำเร็จ', 'กำลังพาไปหน้าแรก…');
  exit;
}else{
    flash_add('danger', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
    redirect_after_show_flash('/n3-sport/login.php', 5000, 'เข้าสู่ระบบไม่สำเร็จ', 'กรุณาลองใหม่อีกครั้ง…');
}
