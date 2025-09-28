<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../../app/bootstrap.php';
require __DIR__ . '/../../app/db.php';


$db = db(); // <-- ฟังก์ชัน db() ของคุณต้องคืน mysqli connection

// รับค่าจากฟอร์ม
$name     = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';
$phoneRaw = trim($_POST['phone'] ?? '');

// validate เบื้องต้น
if ($name === '' || $username === '' || $email === '') {
    $_SESSION['error'] = 'กรอกข้อมูลให้ครบ';
    header('Location: ../register.php'); exit;
}
if ($password !== $confirm) {
    $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
    header('Location: ../register.php'); exit;
}

// phone optional (ไทย 10 หลักขึ้นต้นด้วย 0)
$phone = null;
if ($phoneRaw !== '') {
    if (!preg_match('/^0[0-9]{9}$/', $phoneRaw)) {
        $_SESSION['error'] = 'รูปแบบเบอร์โทรไม่ถูกต้อง';
        header('Location: ../register.php'); exit;
    }
    $phone = $phoneRaw;
}

// ตรวจซ้ำ username หรือ email
$stmt = $db->prepare("SELECT 1 FROM users WHERE username = ? OR email = ? LIMIT 1");
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['error'] = 'Username หรือ Email มีอยู่แล้ว';
    $stmt->close();
    header('Location: ../register.php'); exit;
}
$stmt->close();

// hash password แล้ว insert
// $hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, username, password, email, phone) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $db->error);
}
$stmt->bind_param("sssss", $name, $username, $password, $email, $phone);
$stmt->execute();
$stmt->close();

$_SESSION['success'] = 'สมัครสมาชิกเรียบร้อยแล้ว! เข้าสู่ระบบได้เลย';
header('Location: ../../login.php'); exit;
