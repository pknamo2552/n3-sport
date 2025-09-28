<!-- Start bootstrap -->
<?php
require __DIR__ . '/app/bootstrap.php';
page_start('Equipment');
?>

<!-- Start DB Model -->
<?php require __DIR__ . '/app/models/equipment_model.php'; ?>

<!-- Import Helper function -->
<?php require __DIR__ . '/utils/borrow_service/equipment_helper.php'; ?>

<?php
  $db = db();
  $q = trim($_GET['q'] ?? '');
  $items = equipment_all($db, $q);

  // Filter by keyword
  $q = mb_strtolower(trim($_GET['q'] ?? ''));
  if ($q !== '') {
    $items = array_values(array_filter($items, function ($it) use ($q) {
      return str_contains(mb_strtolower($it['name']), $q) || str_contains(mb_strtolower($it['desc']), $q);
    }));
  }
?>

<body>
  <!-- Content -->
  <main id="content" class="container py-2">
    <header class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <h1 class="h4 mb-0">รายการอุปกรณ์</h1>

      <form class="d-flex gap-2" method="get" action="">
        <input class="form-control form-control-sm" type="search" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
          placeholder="ค้นหา: ฟุตบอล, วอลเลย์บอล, แบด..."
          aria-label="ค้นหาอุปกรณ์">
        <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-search me-1"></i>ค้นหา</button>
      </form>
    </header>

    <?php if (isset($_GET['borrow']) && $_GET['borrow'] === 'success'): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i> ทำรายการยืมสำเร็จแล้ว
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php elseif (isset($_GET['borrow']) && $_GET['borrow'] === 'fail'): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i> ทำรายการไม่สำเร็จ (สต็อกอาจไม่พอ)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>


    <section>
      <div class="row g-3 g-lg-4">
        <?php foreach ($items as $it): ?>
          <?php
          $left = (int)$it['stock'];
          $disabled = $left <= 0 ? ' disabled' : '';
          $btnLabel = $left <= 0 ? 'หมด (Out of stock)' : 'ยืม';
          $img = $it['image_url'] ?: 'assets/img/logo2.png';
          ?>
          <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100 shadow-sm border-0">
              <img src="<?= e($img) ?>" class="card-img-top" alt="<?= e($it['name']) ?>"
                style="height:180px; object-fit:cover;">
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start">
                  <h5 class="card-title mb-1"><?= e($it['name']) ?></h5>
                  <?= ui_stock_badge($left) ?>
                </div>
                <p class="card-text small text-muted mb-3"><?= e($it['description'] ?? '') ?></p>

                <div class="mt-auto d-flex gap-2">
                  <a href="utils/borrow.php?id=<?= (int)$it['id'] ?>&qty=1"
                    class="btn btn-primary btn-sm flex-grow-1<?= $disabled ?>">
                    <i class="bi bi-bag-plus me-1"></i><?= $btnLabel ?>
                  </a>
                  <a href="equipment_detail.php?id=<?= (int)$it['id'] ?>"
                    class="btn btn-outline-secondary btn-sm">
                    รายละเอียด
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <?php if (empty($items)): ?>
          <div class="col-12">
            <div class="alert alert-light border d-flex align-items-center" role="alert">
              <i class="bi bi-search me-2"></i>
              ไม่พบอุปกรณ์ที่ตรงกับ “<?= e($q) ?>”
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <!-- Provider -->
  <script src="assets/js/main.js"></script>
  <script src="./js/layout-utils.js"></script>

  <!-- Script Init -->
  <script>
    LayoutUtils.autoSpacing({
      header: 'header',
      target: 'content',
      extra: 8,
      mode: 'margin'
    });
  </script>
</body>

<?php page_end(); ?>

</html>