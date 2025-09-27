<?php require __DIR__ . '/app/bootstrap.php'; page_start('Register'); ?>

<body>
  <!-- Content -->
  <main id="content" class="container py-2">
    <div class="row justify-content-center">
     <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">

        <div class="card shadow-sm mt-4">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-person-plus" style="font-size: 2.5rem;"></i>
              <h1 class="h4 mt-2 mb-0">สมัครสมาชิก</h1>
              <p class="text-muted small">Create your N3 Sport account</p>
            </div>

              <div class="mb-3">
                <label class="form-label">Username | ชื่อผู้ใช้</label>
                <input type="text" class="form-control" name="username" required>
                <div class="invalid-feedback">กรอกชื่อผู้ใช้ด้วยนะ</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
                <div class="invalid-feedback">กรอกอีเมลให้ถูกต้อง</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Password | รหัสผ่าน</label>
                <div class="input-group">
                  <input type="password" class="form-control" name="password" id="regPass" minlength="6" required>
                  <button class="btn btn-outline-secondary" type="button" id="togglePass">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
                <div class="invalid-feedback">กรอกรหัสผ่าน (≥ 6 ตัวอักษร)</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Confirm password | ยืนยันรหัสผ่าน</label>
                <input type="password" class="form-control" name="confirm_password" id="regPass2" required>
                <div class="invalid-feedback">รหัสผ่านไม่ตรงกัน</div>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
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

    <!-- Footer -->

  <!-- Provider / Vendor JS) ( BS , Custom ) -->
  <script src="assets/js/main.js"></script> 
  <script src="assets/js/layout-utils.js"></script>
  
  <script>
    // กัน header fixed-top ชนเนื้อหา
    LayoutUtils.autoSpacing({
      header: 'header',
      target: 'content',
      extra: 8,
      mode: 'margin'
    });

    // Bootstrap client-side validation + ตรวจรหัสผ่านตรงกัน
    (function () {
      const form = document.forms['formRegister'];
      if (!form) return;

      function passwordsMatch() {
        const p1 = form['password'].value;
        const p2 = form['confirm_password'].value;
        const same = p1 && p1.length >= 6 && p1 === p2;
        form['confirm_password'].setCustomValidity(same ? '' : 'Mismatch');
        return same;
      }

      form['password'].addEventListener('input', passwordsMatch);
      form['confirm_password'].addEventListener('input', passwordsMatch);

      form.addEventListener('submit', function (e) {
        if (!form.checkValidity() || !passwordsMatch()) {
          e.preventDefault();
          e.stopPropagation();
        }
        form.classList.add('was-validated');
      });

      // toggle แสดง/ซ่อนรหัสผ่าน
      const toggleBtn = document.getElementById('togglePass');
      const passInput = document.getElementById('regPass');
      if (toggleBtn && passInput) {
        toggleBtn.addEventListener('click', function () {
          const isText = passInput.type === 'text';
          passInput.type = isText ? 'password' : 'text';
          this.innerHTML = isText ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
        });
      }
    })();
  </script>
</body>

<?php page_end(); ?>

</html>
