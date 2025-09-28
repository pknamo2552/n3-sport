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
<!-- Limit Borrow -->
<?php if (($_GET['borrow'] ?? '') === 'limit'): ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i>
    คุณยืมครบเพดานที่อนุญาตต่อผู้ใช้แล้ว กรุณาคืนบางรายการก่อน
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<!-- Alert -->
<?php flash_render(); ?>

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
                  <!-- ใหม่: เปิด Modal -->
                  <button
                    type="button"
                    class="btn btn-primary btn-sm flex-grow-1<?= $disabled ?>"
                    data-bs-toggle="modal"
                    data-bs-target="#borrowModal"
                    data-id="<?= (int)$it['id'] ?>"
                    data-name="<?= e($it['name']) ?>"
                    data-stock="<?= (int)$it['stock'] ?>"
                    <?= $disabled ? 'disabled' : '' ?>>
                    <i class="bi bi-bag-plus me-1"></i><?= $btnLabel ?>
                  </button>
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


<!-- Borrow Modal -->
<div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="post" action="utils/borrow_service/borrow.php">
      <div class="modal-header">
        <h5 class="modal-title" id="borrowModalLabel">ยืมอุปกรณ์</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="equipment_id" id="bm-equipment-id">

        <div class="mb-3">
          <label class="form-label">อุปกรณ์</label>
          <input type="text" class="form-control" id="bm-equipment-name" disabled>
        </div>

        <div class="mb-3">
          <div class="d-flex justify-content-between">
            <label for="bm-qty" class="form-label mb-0">จำนวนที่ยืม</label>
            <small class="text-muted">คงเหลือ: <span id="bm-stock">0</span></small>
          </div>
          <input type="number" class="form-control"
            id="bm-qty" name="qty"
            min="1" value="1" required inputmode="numeric" pattern="[0-9]*">
          <div class="form-text">ใส่จำนวน 1–2 ชุด (ไม่เกินจำนวนคงเหลือ)</div>
        </div>

        <div class="mb-3">
          <label for="bm-due" class="form-label">กำหนดวันคืน</label>
          <input type="date" class="form-control" id="bm-due" name="due_date" required>
          <div class="form-text">เลือกวันคืนภายใน 14 วันนับจากวันนี้</div>
        </div>

        <div class="mb-3">
          <label class="form-label">หมายเหตุ (ไม่บังคับ)</label>
          <textarea class="form-control" name="note" rows="2" placeholder="เช่น ขอรับพรุ่งนี้เช้า"></textarea>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" id="bm-confirm" required>
          <label class="form-check-label" for="bm-confirm">ยืนยันการยืมตามจำนวนและวันคืนที่ระบุ</label>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i>ยืนยันการยืม</button>
      </div>
    </form>
  </div>
</div>

<script>
  (function() {
    const modal = document.getElementById('borrowModal');
    const qty = document.getElementById('bm-qty');
    const stockSpan = document.getElementById('bm-stock');
    const due = document.getElementById('bm-due');

    function fmtDate(d) {
      const z = n => String(n).padStart(2, '0');
      return `${d.getFullYear()}-${z(d.getMonth()+1)}-${z(d.getDate())}`;
    }

    modal.addEventListener('show.bs.modal', (ev) => {
      const btn = ev.relatedTarget;
      const id = btn.getAttribute('data-id');
      const name = btn.getAttribute('data-name');
      const stock = parseInt(btn.getAttribute('data-stock') || '0', 10);

      document.getElementById('bm-equipment-id').value = id;
      document.getElementById('bm-equipment-name').value = name;
      stockSpan.textContent = stock;

      // ✅ จำกัดจำนวนสูงสุด: min(stock, 2)
      const HARD_MAX = 2;
      qty.min = 1;
      qty.max = Math.min(stock, HARD_MAX);
      qty.value = Math.min(1, qty.max) || 1;

      // วันคืน: วันนี้..+14 วัน (เหมือนเดิม)
      const today = new Date();
      const max = new Date();
      max.setDate(today.getDate() + 14);
      due.min = fmtDate(today);
      due.max = fmtDate(max);
      due.value = fmtDate(max);

      document.getElementById('bm-confirm').checked = false;
    });

    // กันกรอกเกิน max / ต่ำกว่า 1
    qty.addEventListener('input', function() {
      const max = parseInt(this.max || '0', 10);
      let v = parseInt(this.value || '0', 10);
      if (isNaN(v) || v < 1) v = 1;
      if (max && v > max) v = max;
      this.value = v;
    });
  })();
</script>

<?php page_end(); ?>

</html>