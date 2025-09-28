<?php
require __DIR__ . '/../../app/db.php';
require __DIR__ . '/../../app/helpers.php';
session_start();

$full  = trim($_POST['full_name'] ?? '');
$user  = trim($_POST['username']  ?? '');
$email = trim($_POST['email']     ?? '');
$phone = trim($_POST['phone']     ?? '');
$pass  = $_POST['password']        ?? '';
$pass2 = $_POST['password_confirm']?? '';

if ($full==='' || $user==='' || $email==='' || $phone==='' || $pass==='' || $pass2==='') {
  flash_add('danger','กรุณากรอกข้อมูลให้ครบ');
  redirect_after_show_flash('/n3-sport/register.php', 1500, 'สมัครไม่สำเร็จ', 'ข้อมูลไม่ครบ');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  flash_add('danger','รูปแบบอีเมลไม่ถูกต้อง');
  redirect_after_show_flash('/n3-sport/register.php', 1500, 'สมัครไม่สำเร็จ');
}

if (!preg_match('/^[A-Za-z0-9_]{4,20}$/', $user)) {
  flash_add('danger','Username ต้องเป็นตัวอักษร/ตัวเลข/ขีดล่าง 4–20 ตัว');
  redirect_after_show_flash('/n3-sport/register.php', 1500, 'สมัครไม่สำเร็จ');
}

if (strlen($pass) < 6) {
  flash_add('danger','รหัสผ่านต้องอย่างน้อย 6 ตัวอักษร');
  redirect_after_show_flash('/n3-sport/register.php', 1500, 'สมัครไม่สำเร็จ');
}

if ($pass !== $pass2) {
  flash_add('danger','รหัสผ่านและยืนยันรหัสผ่านต้องตรงกัน');
  redirect_after_show_flash('/n3-sport/register.php', 1500, 'สมัครไม่สำเร็จ');
}

$mysqli = db();

// ซ้ำ
$stmt = $mysqli->prepare("SELECT COUNT(*) cnt FROM users WHERE username=?");
$stmt->bind_param('s', $user);
$stmt->execute(); $dupU = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0; $stmt->close();

$stmt = $mysqli->prepare("SELECT COUNT(*) cnt FROM users WHERE email=?");
$stmt->bind_param('s', $email);
$stmt->execute(); $dupE = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0; $stmt->close();

if ($dupU) { flash_add('danger','Username นี้ถูกใช้แล้ว'); redirect_after_show_flash('/n3-sport/register.php', 1500, 'สมัครไม่สำเร็จ'); }
if ($dupE) { flash_add('danger','E-mail นี้ถูกใช้แล้ว');   redirect_after_show_flash('/n3-sport/register.php', 1500, 'สมัครไม่สำเร็จ'); }

$stmt = $mysqli->prepare("INSERT INTO users (username, name, email, phone, password) VALUES (?,?,?,?,?)");
$stmt->bind_param('sssss', $user, $full, $email, $phone, $pass);
$stmt->execute(); $stmt->close();

// auto login (ถ้าต้องการ)
$_SESSION['username'] = $user;
$_SESSION['name']     = $full;
$_SESSION['email']    = $email;
$_SESSION['phone']    = $phone;
$_SESSION['status']   = 'online';

flash_add('success', 'สมัครสมาชิกสำเร็จ ยินดีต้อนรับ ' . $full);
redirect_after_show_flash('/n3-sport/index.php', 1200, 'สมัครสำเร็จ', 'กำลังพาไปหน้าแรก…');
