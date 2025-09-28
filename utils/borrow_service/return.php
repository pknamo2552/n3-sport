<?php
require __DIR__ . '/../../app/db.php';
require __DIR__ . '/../../app/helpers.php';
session_start();

if (empty($_SESSION['username'])) {
  flash_add('warning', 'กรุณาเข้าสู่ระบบ');
  header('Location:/n3-sport/login.php');
  exit;
}

$borrowId = (int)($_GET['id'] ?? 0);
if ($borrowId <= 0) {
  flash_add('danger', 'คำขอไม่ถูกต้อง');
  header('Location:/n3-sport/borrows.php');
  exit;
}

$mysqli = db();

// user ปัจจุบัน
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$user) {
  flash_add('danger', 'ไม่พบผู้ใช้');
  header('Location:/n3-sport/login.php');
  exit;
}

$mysqli->begin_transaction();
try {
  $stmt = $mysqli->prepare("SELECT id, user_id, equipment_id, qty, status FROM borrows WHERE id=? FOR UPDATE");
  $stmt->bind_param('i', $borrowId);
  $stmt->execute();
  $bor = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  if (!$bor || (int)$bor['user_id'] !== (int)$user['id']) throw new Exception('ไม่พบรายการยืมของคุณ');
  if ($bor['status'] === 'returned') throw new Exception('รายการนี้คืนแล้ว');

  $stmt = $mysqli->prepare("UPDATE borrows SET status='returned' WHERE id=?");
  $stmt->bind_param('i', $borrowId);
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("UPDATE equipment SET stock = stock + ? WHERE id=?");
  $stmt->bind_param('ii', $bor['qty'], $bor['equipment_id']);
  $stmt->execute();
  $stmt->close();

  $mysqli->commit();
  flash_add('success', 'คืนอุปกรณ์เรียบร้อยแล้ว');
  header('Location: /n3-sport/borrow.php');
} catch (Throwable $e) {
  $mysqli->rollback();
  flash_add('danger', 'ทำรายการไม่สำเร็จ: ' . $e->getMessage());
  header('Location: /n3-sport/borrow.php');
}
