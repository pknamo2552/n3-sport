<?php
require __DIR__ . '/../../app/db.php';
require __DIR__ . '/../../app/helpers.php';
session_start();

if (empty($_SESSION['username'])) { flash_add('warning','กรุณาเข้าสู่ระบบ'); header('Location:/n3-sport/login.php'); exit; }

$mysqli = db();
$name     = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$pwd1     = $_POST['new_password'] ?? '';
$pwd2     = $_POST['confirm_password'] ?? '';

if ($name === '' || $username === '' || $email === '') {
  flash_add('danger','กรอกข้อมูลให้ครบ (Name/Username/E-mail)'); header('Location:/n3-sport/profile.php'); exit;
}
if ($pwd1 !== '' || $pwd2 !== '') {
  if ($pwd1 !== $pwd2) { flash_add('danger','รหัสผ่านใหม่และยืนยันต้องตรงกัน'); header('Location:/n3-sport/profile.php'); exit; }
  if (strlen($pwd1) < 6) { flash_add('danger','รหัสผ่านใหม่ต้องอย่างน้อย 6 ตัวอักษร'); header('Location:/n3-sport/profile.php'); exit; }
}

// ตัวเอง
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute(); $self = $stmt->get_result()->fetch_assoc(); $stmt->close();
if (!$self) { flash_add('danger','ไม่พบผู้ใช้'); header('Location:/n3-sport/login.php'); exit; }
$uid = (int)$self['id'];

// ซ้ำ
$stmt = $mysqli->prepare("SELECT COUNT(*) cnt FROM users WHERE username=? AND id<>?");
$stmt->bind_param('si', $username, $uid); $stmt->execute(); $dupU = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0; $stmt->close();
$stmt = $mysqli->prepare("SELECT COUNT(*) cnt FROM users WHERE email=? AND id<>?");
$stmt->bind_param('si', $email, $uid); $stmt->execute(); $dupE = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0; $stmt->close();
if ($dupU) { flash_add('danger','Username นี้ถูกใช้แล้ว'); header('Location:/n3-sport/profile.php'); exit; }
if ($dupE) { flash_add('danger','E-mail นี้ถูกใช้แล้ว'); header('Location:/n3-sport/profile.php'); exit; }

// อัปเดต
if ($pwd1 !== '') {
  $stmt = $mysqli->prepare("UPDATE users SET name=?, username=?, email=?, phone=?, password=? WHERE id=?");
  $stmt->bind_param('sssssi', $name, $username, $email, $phone, $pwd1, $uid);
} else {
  $stmt = $mysqli->prepare("UPDATE users SET name=?, username=?, email=?, phone=? WHERE id=?");
  $stmt->bind_param('ssssi', $name, $username, $email, $phone, $uid);
}
$stmt->execute(); $stmt->close();

$_SESSION['username'] = $username;
$_SESSION['name']     = $name;
$_SESSION['email']    = $email;
$_SESSION['phone']    = $phone;

flash_add('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
header('Location: /n3-sport/profile.php');
