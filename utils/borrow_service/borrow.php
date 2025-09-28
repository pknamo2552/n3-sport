<?php
// ใช้: utils/borrow.php?id=EQUIP_ID&qty=1
require __DIR__ . '/../../app/db.php';
session_start();

// 1) Check Login
if (empty($_SESSION['username'])) {
  header('Location: /n3-sport/login.php');
  exit;
}

// 2) Get param
$equipId = (int)($_GET['id'] ?? 0);
$qty     = max(1, (int)($_GET['qty'] ?? 1));

if ($equipId <= 0) {
  header('Location: /n3-sport/equipment.php?borrow=fail');
  exit;
}

$mysqli = db();

// 3) Find user id from username
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
  header('Location: /n3-sport/login.php');
  exit;
}

$mysqli->begin_transaction();
try {
  // 4) Check stock
  $stmt = $mysqli->prepare("SELECT id, stock FROM equipment WHERE id=? FOR UPDATE");
  $stmt->bind_param('i', $equipId);
  $stmt->execute();
  $item = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  if (!$item) {
    throw new Exception('ไม่พบอุปกรณ์');
  }
  if ((int)$item['stock'] < $qty) {
    throw new Exception('สต็อกไม่พอ');
  }

  // 5) Reduce Stock
  $stmt = $mysqli->prepare("UPDATE equipment SET stock = stock - ? WHERE id = ? AND stock >= ?");
  $stmt->bind_param('iii', $qty, $equipId, $qty);
  $stmt->execute();
  $stmt->close();

  if ($mysqli->affected_rows === 0) {
    throw new Exception('สต็อกไม่พอ (ระหว่างทำรายการ)');
  }

  // 6) Record Borrow
  $stmt = $mysqli->prepare("INSERT INTO borrows (user_id, equipment_id, qty, status) VALUES (?, ?, ?, 'borrowed')");
  $stmt->bind_param('iii', $user['id'], $equipId, $qty);
  $stmt->execute();
  $stmt->close();

  $mysqli->commit();
  header('Location: /n3-sport/equipment.php?borrow=success');
} catch (Throwable $e) {
  $mysqli->rollback();
  header('Location: /n3-sport/equipment.php?borrow=fail');
}
