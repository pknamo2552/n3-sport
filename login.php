<?php require __DIR__ . '/app/bootstrap.php'; page_start('Login'); ?>

<body>
  <!-- Content -->
  <main id="content" class="container py-2">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">

        <div class="card shadow-sm mt-4">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-person-circle" style="font-size: 2.5rem;"></i>
              <h1 class="h4 mt-2 mb-0">เข้าสู่ระบบ</h1>
              <p class="text-muted small">Sign in to N3 Sport</p>
            </div>

            <form name="formLogin" method="post" action="page/checklogin.php" novalidate>
              <div class="mb-3">
                <label class="form-label">Username | ชื่อผู้ใช้</label>
                <input type="text" class="form-control" name="username" required>
                <div class="invalid-feedback">กรอกชื่อผู้ใช้ด้วยนะ</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Password | รหัสผ่าน</label>
                <input type="password" class="form-control" name="password" required>
                <div class="invalid-feedback">กรอกรหัสผ่านด้วยนะ</div>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">เข้าสู่ระบบ</button>
                <button type="reset" class="btn btn-outline-secondary">ล้างข้อมูล</button>
              </div>
            </form>

            <div class="text-center mt-3">
              <a href="#" class="small">ลืมรหัสผ่าน?</a>
            </div>
          </div>
        </div>

        <p class="text-center text-muted small mt-3 mb-0">
          ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a>
        </p>

      </div>
    </div>
  </main>

  <!-- Vendor JS -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/layout-utils.js"></script>

  <script>
    // กัน header fixed-top ชนเนื้อหา (margin-top ที่ #content)
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