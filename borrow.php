<?php
require __DIR__ . '/app/bootstrap.php';
require __DIR__ . '/app/db.php';

if (empty($_SESSION['username'])) {
  header('Location: /n3-sport/login.php');
  exit;
}

$mysqli = db();

// user ปัจจุบัน
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$borrows = [];
if ($user) {
  $stmt = $mysqli->prepare("
    SELECT b.id, b.qty, b.status, b.created_at,
           e.name AS equipment_name, e.image_url
    FROM borrows b
    JOIN equipment e ON e.id = b.equipment_id
    WHERE b.user_id = ?
    ORDER BY b.id DESC
  ");
  $stmt->bind_param('i', $user['id']);
  $stmt->execute();
  $borrows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
}

page_start('My Borrows');
?>

<!-- Alert -->
<?php flash_render(); ?>

<header class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="h5 mb-0">การยืมของฉัน</h1>
  <a href="equipment.php" class="btn btn-sm btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> กลับไปเลือกอุปกรณ์
  </a>
</header>

<?php if (($_GET['msg'] ?? '') === 'returned'): ?>
  <div class="alert alert-success">คืนอุปกรณ์เรียบร้อยแล้ว</div>
<?php elseif (($_GET['msg'] ?? '') === 'fail'): ?>
  <div class="alert alert-danger">ทำรายการไม่สำเร็จ</div>
<?php endif; ?>

<div class="row g-3">
  <?php foreach ($borrows as $b): ?>
    <?php
      $badge = 'bg-secondary';
      if ($b['status'] === 'borrowed') $badge = 'bg-primary';
      if ($b['status'] === 'returned') $badge = 'bg-success';

      $img = trim((string)($b['image_url'] ?? ''));
      if ($img === '') $img = 'assets/img/logo2.png';
    ?>
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="row g-0 align-items-center">
          <div class="col-auto">
            <img src="<?= e($img) ?>" alt="" style="width:120px;height:80px;object-fit:cover" class="rounded-start">
          </div>
          <div class="col">
            <div class="card-body py-2">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="fw-semibold"><?= e($b['equipment_name']) ?></div>
                  <div class="small text-muted">จำนวน: <?= (int)$b['qty'] ?> | วันที่: <?= e($b['created_at']) ?></div>
                </div>
                <span class="badge <?= $badge ?>"><?= e($b['status']) ?></span>
              </div>
            </div>
          </div>
          <div class="col-auto pe-3">
            <?php if ($b['status'] === 'borrowed'): ?>
              <a href="utils/borrow_service/return.php?id=<?= (int)$b['id'] ?>" class="btn btn-sm btn-outline-success">คืนอุปกรณ์</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <?php if (empty($borrows)): ?>
    <div class="col-12">
      <div class="alert alert-light border">ยังไม่พบรายการยืมของคุณ</div>
    </div>
  <?php endif; ?>
</div>

<?php page_end(); ?>
