<?php
require __DIR__ . '/app/bootstrap.php';
page_start('Register');
?>

<main id="content" class="container py-4">
  <?php flash_render(); ?>

  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <div class="text-center mb-3">
            <i class="bi bi-person-plus" style="font-size:2rem;"></i>
            <h1 class="h4 mt-2 mb-0">สมัครสมาชิก</h1>
            <p class="text-muted small">สร้างบัญชีใหม่ใน N3 Sport</p>
          </div>

          
          <form id="formRegister" class="needs-validation" method="post" action="utils/login_regis_service/register.php" novalidate>
            <div class="mb-3">
              <label class="form-label">ชื่อ-นามสกุล</label>
              <input type="text" class="form-control" name="full_name" required minlength="2">
              <div class="invalid-feedback">กรอกชื่อ-นามสกุลอย่างน้อย 2 ตัวอักษร</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" name="username"
                     required pattern="[A-Za-z0-9_]{4,20}" minlength="4" maxlength="20"
                     aria-describedby="uHelp">
              <div class="invalid-feedback">ใช้ตัวอักษร/ตัวเลข/ขีดล่าง 4–20 ตัว</div>
            </div>

            <div class="mb-3">
              <label class="form-label">E-mail</label>
              <input type="email" class="form-control" name="email" required>
              <div class="invalid-feedback">รูปแบบอีเมลไม่ถูกต้อง</div>
            </div>

            <div class="mb-3">
              <label class="form-label">เบอร์โทร</label>
              <input type="tel" class="form-control" name="phone"
                     required pattern="^[0-9+\-\s]{8,20}$" aria-describedby="pHelp">
              <div class="invalid-feedback">รูปแบบเบอร์โทรไม่ถูกต้อง</div>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" name="password" required minlength="6">
                <div class="invalid-feedback">รหัสผ่านอย่างน้อย 6 ตัวอักษร</div>
              </div>
              <div class="col-md-6">
                <label class="form-label">ยืนยันรหัสผ่าน</label>
                <input type="password" class="form-control" name="password_confirm" required minlength="6">
                <div class="invalid-feedback">ยืนยันรหัสผ่านให้ตรงกัน</div>
              </div>
            </div>

            <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" value="1" id="agree" required>
              <label class="form-check-label" for="agree">ยอมรับเงื่อนไขการใช้งาน</label>
              <div class="invalid-feedback">กรุณายอมรับเงื่อนไขก่อนสมัคร</div>
            </div>

            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-success">สมัครสมาชิก</button>
              <a class="btn btn-outline-secondary" href="login.php">มีบัญชีอยู่แล้ว? เข้าสู่ระบบ</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
// Bootstrap validation + เช็ครหัสผ่านให้ตรงกัน
(() => {
  const form = document.getElementById('formRegister');
  form.addEventListener('submit', (e) => {
    // 1) ให้ browser ตรวจ required/pattern/minlength ก่อน
    if (!form.checkValidity()) {
      e.preventDefault(); e.stopPropagation();
    }

    // 2) เช็ครหัสผ่านตรงกัน
    const pwd = form.elements['password'].value.trim();
    const cf  = form.elements['password_confirm'].value.trim();
    if (pwd !== cf) {
      e.preventDefault(); e.stopPropagation();
      form.elements['password_confirm'].setCustomValidity('notmatch');
    } else {
      form.elements['password_confirm'].setCustomValidity('');
    }

    form.classList.add('was-validated');
  });

  // เคลียร์ customValidity เมื่อแก้ไข
  form.elements['password_confirm'].addEventListener('input', function(){
    this.setCustomValidity('');
  });
})();
</script>

<?php page_end(); ?>
