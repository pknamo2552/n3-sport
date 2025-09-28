<?php
// ใช้: utils/return.php?id=BORROW_ID
require __DIR__ . '/../../app/db.php';
session_start();

if (empty($_SESSION['username'])) {
  header('Location: /n3-sport/login.php');
  exit;
}

$borrowId = (int)($_GET['id'] ?? 0);
if ($borrowId <= 0) {
  header('Location: /n3-sport/borrows.php?msg=invalid');
  exit;
}

$mysqli = db();

// ดึง user_id ปัจจุบัน
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
  // Get borrow list to check
  $stmt = $mysqli->prepare("SELECT id, user_id, equipment_id, qty, status FROM borrows WHERE id=? FOR UPDATE");
  $stmt->bind_param('i', $borrowId);
  $stmt->execute();
  $bor = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  if (!$bor || (int)$bor['user_id'] !== (int)$user['id']) {
    throw new Exception('ไม่พบรายการยืมของคุณ');
  }
  if ($bor['status'] === 'returned') {
    throw new Exception('คืนแล้ว');
  }

  // Update state to return
  $stmt = $mysqli->prepare("UPDATE borrows SET status='returned' WHERE id=?");
  $stmt->bind_param('i', $borrowId);
  $stmt->execute();
  $stmt->close();

  // Add stock back
  $stmt = $mysqli->prepare("UPDATE equipment SET stock = stock + ? WHERE id=?");
  $stmt->bind_param('ii', $bor['qty'], $bor['equipment_id']);
  $stmt->execute();
  $stmt->close();

  $mysqli->commit();
  header('Location: /n3-sport/borrows.php?msg=returned');
} catch (Throwable $e) {
  $mysqli->rollback();
  header('Location: /n3-sport/borrows.php?msg=fail');
}
