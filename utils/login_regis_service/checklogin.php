<?php
// page/checklogin.php
require __DIR__ . '/../../app/bootstrap.php';
require __DIR__ . '/../../app/db.php';

// ---------- Helper to redirect ----------
function redirect(string $path): void {
    header("Location: $path");
    exit;
}

// ---------- Read Input from form ----------
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// ถ้าเว้นว่าง → กลับไปหน้า login
if ($username === '' || $password === '') {
    // ถ้ามีระบบ flash ก็ใส่ข้อความใน $_SESSION['error'] ได้
    redirect('../login.php'); // อยู่คนละโฟลเดอร์กับ checklogin.php
}

// ---------- Connect to database ----------
$conn = db();

// ---------- Query (Prepared Statement) ----------
$sql  = "SELECT id, name, username, password, phone, email, status
         FROM users
         WHERE username = ? AND password = ?
         LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    redirect('../../login.php');
}

mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user   = $result ? mysqli_fetch_assoc($result) : null;

// ---------- Check result ----------
if (!$user) {
    // ไม่พบบัญชีหรือรหัสผ่านไม่ถูกต้อง
    redirect('../../login.php');
}

// ---------- Set session ----------
$_SESSION['id']       = $user['id'];
$_SESSION['name']     = $user['name'];
$_SESSION['username'] = $user['username'];
$_SESSION['phone']    = $user['phone'];
$_SESSION['email']    = $user['email'];
$_SESSION['status']   = $user['status'];

session_write_close();

// ---------- Redirect by role ----------
if ($user['status'] === 'admin') {
    redirect('../../admin.php');
} else {
    redirect('../../profile.php');
}

// ---------- Cleanup ----------
mysqli_stmt_close($stmt);
mysqli_close($conn);
