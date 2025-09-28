<?php
require __DIR__ . '/../../app/db.php';
require __DIR__ . '/../../app/helpers.php'; // ต้องมีเพื่อใช้ flash
session_start();

if (empty($_SESSION['username'])) {
  flash_add('warning', 'กรุณาเข้าสู่ระบบก่อนทำรายการ');
  header('Location: /n3-sport/login.php'); exit;
}

const MAX_QTY_PER_BORROW        = 2;  // ยืมได้ครั้งละไม่เกิน 2
const MAX_ACTIVE_ITEMS_PER_USER = 5;  // รวมที่ยืมค้างสถานะ borrowed ไม่เกิน 5
const MAX_DAYS_AHEAD            = 14; // กำหนดวันคืนภายใน 14 วัน

$equipId  = (int)($_POST['equipment_id'] ?? 0);
$qty      = max(1, (int)($_POST['qty'] ?? 1));
$note     = trim($_POST['note'] ?? '');
$due_date = trim($_POST['due_date'] ?? '');

if ($equipId <= 0) {
  flash_add('danger', 'คำขอไม่ถูกต้อง'); header('Location: /n3-sport/equipment.php'); exit;
}

$today = new DateTime('today');
try { $due = new DateTime($due_date); } catch(Throwable $e) {
  flash_add('danger', 'รูปแบบวันคืนไม่ถูกต้อง'); header('Location: /n3-sport/equipment.php'); exit;
}
$maxDue = (clone $today)->modify('+' . MAX_DAYS_AHEAD . ' days');
if ($due < $today || $due > $maxDue) {
  flash_add('danger', 'วันคืนต้องอยู่ในช่วงวันนี้ถึง ' . $maxDue->format('Y-m-d'));
  header('Location: /n3-sport/equipment.php'); exit;
}

$mysqli = db();

// ผู้ใช้ปัจจุบัน
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$user) { flash_add('danger', 'ไม่พบข้อมูลผู้ใช้'); header('Location: /n3-sport/login.php'); exit; }

// ตรวจยอดค้างยืม
$stmt = $mysqli->prepare("SELECT IFNULL(SUM(qty),0) AS total FROM borrows WHERE user_id=? AND status='borrowed'");
$stmt->bind_param('i', $user['id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc(); $stmt->close();
$activeTotal = (int)($row['total'] ?? 0);
$remaining   = MAX_ACTIVE_ITEMS_PER_USER - $activeTotal;
if ($remaining <= 0) {
  flash_add('warning', 'คุณยืมครบเพดานที่อนุญาตแล้ว กรุณาคืนบางรายการก่อน');
  header('Location: /n3-sport/equipment.php'); exit;
}
// บังคับเพดานต่อครั้งและรวม
$qty = min($qty, MAX_QTY_PER_BORROW, $remaining);

$mysqli->begin_transaction();
try {
  // ล็อกอุปกรณ์ + เช็คสต็อก
  $stmt = $mysqli->prepare("SELECT id, stock FROM equipment WHERE id=? FOR UPDATE");
  $stmt->bind_param('i', $equipId);
  $stmt->execute();
  $item = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  if (!$item) throw new Exception('ไม่พบอุปกรณ์');
  $stock = (int)$item['stock'];
  if ($qty < 1 || $qty > $stock) throw new Exception('สต็อกไม่พอ');

  // ลดสต็อก
  $stmt = $mysqli->prepare("UPDATE equipment SET stock = stock - ? WHERE id = ? AND stock >= ?");
  $stmt->bind_param('iii', $qty, $equipId, $qty);
  $stmt->execute(); $stmt->close();
  if ($mysqli->affected_rows === 0) throw new Exception('สต็อกไม่พอ (มีคนยืมพร้อมกัน)');

  // บันทึก
  $dueAt = $due->format('Y-m-d 23:59:59');
  $stmt = $mysqli->prepare("
    INSERT INTO borrows (user_id, equipment_id, qty, status, due_at, note)
    VALUES (?, ?, ?, 'borrowed', ?, ?)
  ");
  $stmt->bind_param('iiiss', $user['id'], $equipId, $qty, $dueAt, $note);
  $stmt->execute(); $stmt->close();

  $mysqli->commit();
  flash_add('success', 'ยืมอุปกรณ์สำเร็จ จำนวน ' . $qty . ' ชุด กำหนดคืน: ' . $due->format('Y-m-d'));
  header('Location: /n3-sport/equipment.php'); 
} catch (Throwable $e) {
  $mysqli->rollback();
  flash_add('danger', 'ทำรายการไม่สำเร็จ: ' . $e->getMessage());
  header('Location: /n3-sport/equipment.php');
}
