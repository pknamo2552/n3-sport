<?php require __DIR__ . '/app/bootstrap.php'; page_start('Home'); ?>

<body>
  <main id="content" class="container-lg py-4">

    <!-- Hero -->
    <section class="position-relative overflow-hidden rounded-4 shadow-sm mb-4"
             style="background: linear-gradient(120deg,#0ea5e9 0%, #6366f1 50%, #a855f7 100%);">
      <div class="container py-5">
        <div class="row align-items-center g-4">
          <div class="col-12 col-lg-7 text-white">
            <h1 class="display-6 fw-semibold mb-2">N3 Sport — ระบบยืมอุปกรณ์กีฬา</h1>
            <p class="mb-4 opacity-90">จอง/ยืม-คืน ลูกบอล ลูกแบด ไม้ปิงปอง ตาข่าย และอุปกรณ์อื่น ๆ ได้ง่ายในที่เดียว</p>

            <!-- Quick actions -->
            <div class="d-flex flex-wrap gap-2">
              <a href="equipment.php" class="btn btn-light text-dark">
                <i class="bi bi-bag-check me-1"></i> ดูอุปกรณ์ทั้งหมด
              </a>
              <a href="login.php" class="btn btn-outline-light">
                <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
              </a>
              <a href="register.php" class="btn btn-outline-light">
                <i class="bi bi-person-plus me-1"></i> สมัครสมาชิก
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured equipment -->
    <section class="mb-4">
      <h2 class="h5 mb-3">รายการแนะนำ</h2>
      <div class="row g-3 g-lg-4">

        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://images.unsplash.com/photo-1486286701208-1d58e9338013?q=60&w=1200&auto=format&fit=crop" class="card-img-top" alt="Football">
            <div class="card-body">
              <h5 class="card-title mb-1">ลูกฟุตบอล Match</h5>
              <p class="card-text small text-muted mb-3">ขนาด 5 | สภาพดี | มี 8 ลูก</p>
              <div class="d-flex justify-content-between align-items-center">
                <a href="equipment.php?cat=football" class="btn btn-primary btn-sm">ยืมเลย</a>
                <span class="badge bg-success-subtle text-success border border-success-subtle">พร้อมยืม</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?q=60&w=1200&auto=format&fit=crop" class="card-img-top" alt="Basketball">
            <div class="card-body">
              <h5 class="card-title mb-1">ลูกบาส Indoor/Outdoor</h5>
              <p class="card-text small text-muted mb-3">ไซซ์ 7 | สภาพดีมาก | มี 5 ลูก</p>
              <div class="d-flex justify-content-between align-items-center">
                <a href="equipment.php?cat=basketball" class="btn btn-primary btn-sm">ยืมเลย</a>
                <span class="badge bg-success-subtle text-success border border-success-subtle">พร้อมยืม</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://cdn1.sportngin.com/attachments/call_to_action/e349-190383150/DSC01633-153_large.jpg" class="card-img-top" alt="Volleyball">
            <div class="card-body">
              <h5 class="card-title mb-1">ลูกวอลเลย์บอล</h5>
              <p class="card-text small text-muted mb-3">มาตรฐาน FIVB | มี 6 ลูก</p>
              <div class="d-flex justify-content-between align-items-center">
                <a href="equipment.php?cat=volleyball" class="btn btn-primary btn-sm">ยืมเลย</a>
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">เหลือน้อย</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://xn--12cabu5d3b7bl3d0af0dk4b1bzttc.com/wp-content/uploads/2025/07/%E0%B8%A1%E0%B8%B2%E0%B8%95%E0%B8%A3%E0%B8%90%E0%B8%B2%E0%B8%99%E0%B8%AD%E0%B8%B8%E0%B8%9B%E0%B8%81%E0%B8%A3%E0%B8%93%E0%B9%8C%E0%B9%81%E0%B8%9A%E0%B8%94%E0%B8%A1%E0%B8%B4%E0%B8%99%E0%B8%95%E0%B8%B1%E0%B8%99%E0%B8%97%E0%B8%B5%E0%B9%88%E0%B8%97%E0%B8%B8%E0%B8%81%E0%B8%AA%E0%B8%99%E0%B8%B2%E0%B8%A1%E0%B8%95%E0%B9%89%E0%B8%AD%E0%B8%87%E0%B8%A1%E0%B8%B5-1024x683.png" class="card-img-top" alt="Badminton">
            <div class="card-body">
              <h5 class="card-title mb-1">ชุดแบดมินตัน</h5>
              <p class="card-text small text-muted mb-3">ไม้ + ลูกขนไก่ | พร้อมยืมเป็นชุด</p>
              <div class="d-flex justify-content-between align-items-center">
                <a href="equipment.php?cat=badminton" class="btn btn-primary btn-sm">ยืมเลย</a>
                <span class="badge bg-success-subtle text-success border border-success-subtle">พร้อมยืม</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- How it works -->
    <section class="mb-5">
      <h2 class="h5 mb-3">ใช้งานอย่างไร</h2>
      <div class="row g-3 g-lg-4">
        <div class="col-12 col-lg-4">
          <div class="h-100 p-3 border rounded-3 bg-body-tertiary">
            <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-person-check"></i><strong>สมัคร/เข้าสู่ระบบ</strong></div>
            <p class="mb-0 small text-muted">สมัครสมาชิกใหม่หรือเข้าสู่ระบบด้วยบัญชีที่มีอยู่</p>
          </div>
        </div>
        <div class="col-12 col-lg-4">
          <div class="h-100 p-3 border rounded-3 bg-body-tertiary">
            <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-search"></i><strong>ค้นหาอุปกรณ์</strong></div>
            <p class="mb-0 small text-muted">กรองตามชนิดกีฬาและสถานะพร้อมยืม</p>
          </div>
        </div>
        <div class="col-12 col-lg-4">
          <div class="h-100 p-3 border rounded-3 bg-body-tertiary">
            <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-calendar2-check"></i><strong>จอง/ยืนยันการยืม</strong></div>
            <p class="mb-0 small text-muted">ระบุช่วงเวลาที่ต้องการ ใช้งานสะดวกและตรวจสอบสถานะได้</p>
          </div>
        </div>
      </div>
    </section>

  </main>


  
  <!-- Provider -->
  <script src="assets/js/main.js"></script> 
  <script src="assets/js/layout-utils.js"></script>

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
