<?php require __DIR__ . '/app/bootstrap.php';
page_start('Profile'); ?>

<body>
  <main id="content" class="container">

    <?php
    $name     = e($_SESSION['name']     ?? '');
    $username = e($_SESSION['username'] ?? '');
    $email    = e($_SESSION['email']    ?? '');
    $phone    = e($_SESSION['phone']    ?? '');
    $status   = e($_SESSION['status']   ?? '');
    ?>

    <!-- Hero -->
    <section class="position-relative overflow-hidden rounded-4 shadow-sm mb-4"
      style="background: linear-gradient(120deg,#0ea5e9 0%, #6366f1 60%, #a855f7 100%); min-height: 140px;">
      <div class="h-100 d-flex align-items-center py-5 px-3 px-lg-4">
        <div class="d-flex align-items-center gap-3">
          <img src="https://images.seeklogo.com/logo-png/28/1/premier-league-new-logo-png_seeklogo-286461.png"
            alt="Avatar"
            class="rounded-circle border border-3 border-light shadow"
            style="width:72px;height:72px;object-fit:cover;">
          <div class="text-white">
            <div class="h5 mb-1 fw-semibold"><?= $name ?></div>
            <div class="d-flex flex-wrap gap-2">
              <span class="badge bg-light text-dark text-uppercase">ID: <?= strtoupper($username) ?></span>
              <?php
              $badgeClass = 'bg-secondary';
              if (strtolower($status) === 'online')  $badgeClass = 'bg-success';
              elseif (strtolower($status) === 'away') $badgeClass = 'bg-warning text-dark';
              ?>
              <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Profile Card -->
    <section class="">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-lg-5">

          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title mb-0" id="con4">Profile | ข้อมูลส่วนตัว</h5>
            <span class="text-muted small">ปรับปรุงข้อมูลของคุณได้ที่นี่</span>
          </div>
          <hr class="text-muted" />

          <form id="profileForm" method="post" action="profile_update.php" novalidate>
            <div class="row g-3 g-lg-4">

              <!-- Name -->
              <div class="col-12 col-md-6">
                <label class="form-label small text-muted mb-1"><i class="bi bi-person me-1"></i>Name</label>
                <input type="text" class="form-control-plaintext px-0 fw-medium"
                  name="name" value="<?= $name ?>" readonly data-editable>
              </div>

              <!-- Username -->
              <div class="col-12 col-md-6">
                <label class="form-label small text-muted mb-1"><i class="bi bi-at me-1"></i>Username</label>
                <input type="text" class="form-control-plaintext px-0 fw-medium"
                  name="username" value="<?= $username ?>" readonly data-editable>
              </div>

              <!-- Email -->
              <div class="col-12 col-md-6">
                <label class="form-label small text-muted mb-1"><i class="bi bi-envelope me-1"></i>E-mail</label>
                <input type="email" class="form-control-plaintext px-0"
                  name="email" value="<?= $email ?>" readonly data-editable>
              </div>

              <!-- Phone -->
              <div class="col-12 col-md-6">
                <label class="form-label small text-muted mb-1"><i class="bi bi-telephone me-1"></i>Phone</label>
                <input type="text" class="form-control-plaintext px-0"
                  name="phone" value="<?= $phone ?>" readonly data-editable>
              </div>

              <!-- Password fields: hidden until Edit -->
              <div class="col-12 col-md-6 d-none" data-edit-only>
                <label class="form-label small text-muted mb-1"><i class="bi bi-shield-lock me-1"></i>New Password</label>
                <input type="password" class="form-control" name="new_password"
                  placeholder="(เว้นว่างหากไม่ต้องการเปลี่ยน)" disabled>
              </div>
              <div class="col-12 col-md-6 d-none" data-edit-only>
                <label class="form-label small text-muted mb-1">Confirm New Password</label>
                <input type="password" class="form-control" name="confirm_password"
                  placeholder="ยืนยันรหัสผ่านใหม่" disabled>
              </div>

              <!-- Status (read-only) -->
              <div class="col-12 col-md-6">
                <label class="form-label small text-muted mb-1"><i class="bi bi-activity me-1"></i>Status</label>
                <input type="text" class="form-control-plaintext px-0"
                  value="<?= $status ?>" readonly aria-readonly="true">
              </div>

            </div>

            <!-- Actions -->
            <div class="d-flex flex-wrap gap-2 mt-4">
              <button type="button" id="btnEdit" class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i>Edit information
              </button>
              <button type="submit" id="btnSave" class="btn btn-success d-none">
                <i class="bi bi-check2 me-1"></i>Save
              </button>
              <button type="button" id="btnCancel" class="btn btn-outline-secondary d-none">
                Cancel
              </button>
              <a href="logout.php" class="btn btn-outline-danger ms-auto">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
              </a>
            </div>

          </form>
        </div>
      </div>
    </section>

  </main>

  <!-- Provider -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/layout-utils.js"></script>

  <script>
    // กัน navbar fixed-top ชน content
    LayoutUtils.autoSpacing({
      header: 'header',
      target: 'content',
      extra: 8,
      mode: 'margin'
    });

    // Inline edit
    (function() {
      const form = document.getElementById('profileForm');
      const btnEdit = document.getElementById('btnEdit');
      const btnSave = document.getElementById('btnSave');
      const btnCancel = document.getElementById('btnCancel');

      const editable = Array.from(form.querySelectorAll('[data-editable]'));
      const editOnlyBlocks = Array.from(form.querySelectorAll('[data-edit-only]'));
      const pwd1 = form.elements['new_password'];
      const pwd2 = form.elements['confirm_password'];

      function snapshot() {
        editable.forEach(el => el.dataset.orig = el.value);
      }
      snapshot();

      function togglePwdFields(show) {
        editOnlyBlocks.forEach(b => b.classList.toggle('d-none', !show));
        [pwd1, pwd2].forEach(el => {
          el.disabled = !show;
          el.required = false;
          if (!show) el.value = '';
        });
      }

      function setEditMode(on) {
        editable.forEach(el => {
          if (on) {
            el.readOnly = false;
            el.classList.remove('form-control-plaintext', 'px-0');
            el.classList.add('form-control');
          } else {
            el.readOnly = true;
            el.classList.remove('form-control');
            el.classList.add('form-control-plaintext', 'px-0');
            if (el.dataset.orig !== undefined) el.value = el.dataset.orig;
          }
        });
        togglePwdFields(on);
        btnEdit.classList.toggle('d-none', on);
        btnSave.classList.toggle('d-none', !on);
        btnCancel.classList.toggle('d-none', !on);
      }

      btnEdit.addEventListener('click', () => setEditMode(true));
      btnCancel.addEventListener('click', () => setEditMode(false));

      form.addEventListener('submit', function(e) {
        // เช็ครหัสผ่านใหม่ให้ตรงกัน (กรณีตั้งใจเปลี่ยน)
        if (!pwd1.disabled || !pwd2.disabled) {
          const a = pwd1.value.trim(),
            b = pwd2.value.trim();
          if ((a || b) && a !== b) {
            e.preventDefault();
            e.stopPropagation();
            alert('รหัสผ่านใหม่และยืนยันรหัสผ่านต้องตรงกัน');
          }
        }
      });
    })();
  </script>
</body>

<?php page_end(); ?>

</html>