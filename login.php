<?php
require __DIR__ . '/app/bootstrap.php';
page_start('Login');
?>

<main id="content" class="container py-4">
  <?php flash_render(); ?>

  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">

      <div class="card shadow-sm mt-4">
        <div class="card-body p-4">
          <div class="text-center mb-3">
            <i class="bi bi-person-circle" style="font-size: 2.5rem;"></i>
            <h1 class="h4 mt-2 mb-0">เข้าสู่ระบบ</h1>
            <p class="text-muted small">Sign in to N3 Sport</p>
          </div>

          <form id="formLogin" class="needs-validation" method="post" action="utils/login_regis_service/checklogin.php" novalidate>
            <div class="mb-3">
              <label class="form-label">Username | ชื่อผู้ใช้</label>
              <input type="text" class="form-control" name="username" autocomplete="username" required minlength="3" maxlength="50">
              <div class="invalid-feedback">กรอกชื่อผู้ใช้ให้ถูกต้อง (อย่างน้อย 3 ตัวอักษร)</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Password | รหัสผ่าน</label>
              <input type="password" class="form-control" name="password" autocomplete="current-password" required minlength="1">
              <div class="invalid-feedback">กรอกรหัสผ่านด้วยนะ</div>
            </div>

            <div class="d-grid gap-2">
              <button type="submit" id="btnLogin" class="btn btn-success">เข้าสู่ระบบ</button>
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

<script>
// Bootstrap validation + กันกดส่งซ้ำ + trim ช่องว่างล้วน
(() => {
  const form = document.getElementById('formLogin');
  const btn  = document.getElementById('btnLogin');

  form.addEventListener('submit', (e) => {
    // trim ค่าก่อนตรวจ
    const u = form.elements['username'];
    const p = form.elements['password'];
    u.value = (u.value || '').trim();
    p.value = (p.value || '').trim();

    // ให้ browser ตรวจ required/minlength ก่อน
    if (!form.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
    } else {
      // กันกดซ้ำ
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>กำลังเข้าสู่ระบบ...';
    }

    form.classList.add('was-validated');
  });

  // เมื่อแก้ไขค่า ให้ลบสถานะ invalid
  ['username','password'].forEach(name => {
    form.elements[name].addEventListener('input', function () {
      this.setCustomValidity('');
      this.classList.remove('is-invalid');
    });
  });
})();
</script>

<?php page_end(); ?>
