<?php
// profile_update.php
session_start();
header('Content-Type: application/json; charset=utf-8');

function clean($s){ return trim((string)$s); }
function fail($msg, $code = 400) {
  http_response_code($code);
  echo json_encode(['ok'=>false, 'message'=>$msg], JSON_UNESCAPED_UNICODE);
  exit;
}

try {
  // CSRF เช็คอย่างง่าย
  if (empty($_POST['csrf']) || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    fail('Invalid CSRF token', 400);
  }

  $name     = clean($_POST['name']     ?? '');
  $username = clean($_POST['username'] ?? '');
  $email    = clean($_POST['email']    ?? '');
  $phone    = clean($_POST['phone']    ?? '');
  $status   = strtolower(clean($_POST['status'] ?? ''));

  if ($name === '' || $email === '') {
    fail('Please fill in required fields.', 422);
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail('Invalid email format.', 422);
  }
  if (!in_array($status, ['online','away','offline'], true)) {
    $status = 'offline';
  }

  // ในระบบจริง ให้บันทึกลงฐานข้อมูล แล้วรีเฟรชค่า session จาก DB
  $_SESSION['name']     = $name;
  $_SESSION['username'] = $_SESSION['username'] ?? $username; // ปกติไม่อนุญาตแก้
  $_SESSION['email']    = $email;
  $_SESSION['phone']    = $phone;
  $_SESSION['status']   = $status;

  echo json_encode([
    'ok' => true,
    'data' => [
      'name'     => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
      'username' => htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'),
      'email'    => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
      'phone'    => htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'),
      'status'   => htmlspecialchars($status, ENT_QUOTES, 'UTF-8'),
    ]
  ]);
} catch (Throwable $e) {
  fail('Server error', 500);
}
