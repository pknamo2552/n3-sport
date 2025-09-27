<?php require __DIR__ . '/app/bootstrap.php'; page_start('Equipment'); ?>
<body>
  <!-- Content -->
  <main id="content" class="container py-2">
    <header class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <h1 class="h4 mb-0">รายการอุปกรณ์</h1>

      <!-- ค้นหาง่าย ๆ (optional) -->
      <form class="d-flex gap-2" method="get" action="">
        <input class="form-control form-control-sm" type="search" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
          placeholder="ค้นหา: ฟุตบอล, วอลเลย์บอล, แบด..."
          aria-label="ค้นหาอุปกรณ์">
        <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-search me-1"></i>ค้นหา</button>
      </form>
    </header>

    <?php
    // ------- ตัวอย่างข้อมูล (ต่อ DB ได้โดยแทนส่วนนี้) ----------
    $items = [
      [
        'id'    => 'football-01',
        'name'  => 'Football',
        'img'   => 'https://images.unsplash.com/photo-1486286701208-1d58e9338013?fm=jpg&q=60&w=1200',
        'desc'  => 'Standard football for training and matches.',
        'left'  => 8
      ],
      [
        'id'    => 'basketball-01',
        'name'  => 'Basketball',
        'img'   => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?fm=jpg&q=60&w=1200',
        'desc'  => 'Indoor/outdoor composite leather ball.',
        'left'  => 5
      ],
      [
        'id'    => 'futsal-01',
        'name'  => 'Futsal',
        'img'   => 'https://inwfile.com/s-cz/sphmtn.jpg',
        'desc'  => 'Low-bounce ball for futsal courts.',
        'left'  => 0
      ],
      [
        'id'    => 'volleyball-01',
        'name'  => 'Volleyball',
        'img'   => 'https://cdn1.sportngin.com/attachments/call_to_action/e349-190383150/DSC01633-153_large.jpg',
        'desc'  => 'Official size & weight volleyball.',
        'left'  => 2
      ],
      [
        'id'    => 'badminton-01',
        'name'  => 'Badminton Set',
        'img'   => 'https://xn--12cabu5d3b7bl3d0af0dk4b1bzttc.com/wp-content/uploads/2025/07/%E0%B8%A1%E0%B8%B2%E0%B8%95%E0%B8%A3%E0%B8%90%E0%B8%B2%E0%B8%99%E0%B8%AD%E0%B8%B8%E0%B8%9B%E0%B8%81%E0%B8%A3%E0%B8%93%E0%B9%8C%E0%B9%81%E0%B8%9A%E0%B8%94%E0%B8%A1%E0%B8%B4%E0%B8%99%E0%B8%95%E0%B8%B1%E0%B8%99%E0%B8%97%E0%B8%B5%E0%B9%88%E0%B8%97%E0%B8%B8%E0%B8%81%E0%B8%AA%E0%B8%99%E0%B8%B2%E0%B8%A1%E0%B8%95%E0%B9%89%E0%B8%AD%E0%B8%87%E0%B8%A1%E0%B8%B5-1024x683.png',
        'desc'  => 'Feather shuttlecocks and rackets set.',
        'left'  => 10
      ],
    ];

    // Filter by keyword
    $q = mb_strtolower(trim($_GET['q'] ?? ''));
    if ($q !== '') {
      $items = array_values(array_filter($items, function ($it) use ($q) {
        return str_contains(mb_strtolower($it['name']), $q) || str_contains(mb_strtolower($it['desc']), $q);
      }));
    }

    // helper badge
    function stock_badge(int $left): string
    {
      if ($left <= 0)  return '<span class="badge bg-secondary">หมด</span>';
      if ($left <= 2)  return '<span class="badge bg-warning text-dark">เหลือน้อย: ' . $left . '</span>';
      return '<span class="badge bg-success">คงเหลือ: ' . $left . '</span>';
    }
    ?>

    <section>
      <div class="row g-3 g-lg-4">
        <?php foreach ($items as $it): ?>
          <?php
          $left = (int)$it['left'];
          $disabled = $left <= 0 ? ' disabled' : '';
          $btnLabel = $left <= 0 ? 'หมด (Out of stock)' : 'ยืม';
          ?>
          <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100 shadow-sm border-0">
              <img src="<?= htmlspecialchars($it['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($it['name']) ?>"
                style="height: 180px; object-fit: cover;">
              <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-start justify-content-between">
                  <h5 class="card-title mb-1"><?= htmlspecialchars($it['name']) ?></h5>
                  <div class="mt-2">
                    <?= stock_badge($left) ?>
                  </div>

                </div>
                <p class="card-text small text-muted mb-3"><?= htmlspecialchars($it['desc']) ?></p>

                <div class="mt-auto d-flex gap-2">
                  <a href="borrow.php?id=<?= urlencode($it['id']) ?>"
                    class="btn btn-primary btn-sm flex-grow-1<?= $disabled ?>">
                    <i class="bi bi-bag-plus me-1"></i><?= $btnLabel ?>
                  </a>
                  <a href="equipment_detail.php?id=<?= urlencode($it['id']) ?>"
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
              ไม่พบอุปกรณ์ที่ตรงกับคำค้น “<?= htmlspecialchars($_GET['q'] ?? '') ?>”
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <!-- Back to top -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

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