<?php require __DIR__ . '/app/bootstrap.php';
page_start('Register'); ?>

<body>
  <main id="content" class="container py-2">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6">

        <div class="card shadow-sm mt-4">
          <div class="card-body p-4">
            <div class="text-center mb-4">
              <i class="bi bi-person-plus" style="font-size: 2.8rem;"></i>
              <h1 class="h4 mt-2 mb-1">สมัครสมาชิก</h1>
              <p class="text-muted small">Create your N3 Sport account</p>
            </div>

            <form name="formRegister" method="post" action="utils/login_regis_service/register.php" novalidate>
              <div class="row g-3">
                <!-- Name -->
                <div class="col-12">
                  <label class="form-label">Name | ชื่อ-นามสกุล</label>
                  <input type="text" class="form-control" name="name" required>
                  <div class="invalid-feedback">กรอกชื่อด้วยนะ</div>
                </div>

                <!-- Username + Email -->
                <div class="col-12 col-md-6">
                  <label class="form-label">Username | ชื่อผู้ใช้</label>
                  <input type="text" class="form-control" name="username" required>
                  <div class="invalid-feedback">กรอกชื่อผู้ใช้ด้วยนะ</div>
                </div>
                <div class="col-12 col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" required>
                  <div class="invalid-feedback">กรอกอีเมลให้ถูกต้อง</div>
                </div>

                <!-- Phone -->
                <div class="col-12">
                  <label class="form-label">Phone (optional) | เบอร์โทร (ไม่บังคับ)</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input type="tel" class="form-control" name="phone"
                      placeholder="เช่น 0812345678" inputmode="tel"
                      pattern="^$|^(0[0-9]{9})$" maxlength="10">
                  </div>
                  <div class="form-text">ถ้ากรอก ให้เป็นตัวเลข 10 หลักขึ้นต้นด้วย 0</div>
                  <div class="invalid-feedback">รูปแบบเบอร์โทรไม่ถูกต้อง</div>
                </div>

                <!-- Password + Confirm -->
                <div class="col-12 col-md-6">
                  <label class="form-label">Password | รหัสผ่าน</label>
                  <div class="input-group">
                    <input type="password" class="form-control" name="password" id="regPass" minlength="6" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePass">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback">กรอกรหัสผ่าน (≥ 6 ตัวอักษร)</div>
                </div>
                <div class="col-12 col-md-6">
                  <label class="form-label">Confirm password | ยืนยันรหัสผ่าน</label>
                  <input type="password" class="form-control" name="confirm_password" id="regPass2" required>
                  <div class="invalid-feedback">รหัสผ่านไม่ตรงกัน</div>
                </div>
              </div>

              <!-- Buttons -->
              <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">สมัครสมาชิก</button>
                <button type="reset" class="btn btn-outline-secondary">ล้างข้อมูล</button>
              </div>
            </form>
          </div>
        </div>

        <div class="text-center mt-3">
          <span class="text-muted small">มีบัญชีอยู่แล้ว?</span>
          <a href="login.php" class="small">เข้าสู่ระบบ</a>
        </div>
      </div>
    </div>

  </main>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/layout-utils.js"></script>
  <!-- script validation เดิมของคุณยังใช้ได้ -->
</body>

<?php page_end(); ?>

</html>