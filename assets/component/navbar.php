<?php $loggedIn = !empty($_SESSION['username']); ?>

<nav class="navbar navbar-expand-lg fixed-top bg-body border-bottom shadow-sm" id="header">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $GLOBALS['base'] ?>index.php">
      <img src="<?= $GLOBALS['base'] ?>assets/img/logo2.png" alt="N3 Sport" style="height:36px">
      <span class="fw-semibold">N3 Sport</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link<?= is_active(file: 'equipment.php') ?>" href="<?= $GLOBALS['base'] ?>equipment.php">Equipment</a></li>

        <?php if (!$loggedIn): ?>
          <li class="nav-item"><a class="nav-link<?= is_active('login.php') ?>" href="<?= $GLOBALS['base'] ?>login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link<?= is_active('register.php') ?>" href="<?= $GLOBALS['base'] ?>register.php">Register</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link<?= is_active('profile.php') ?>" href="<?= $GLOBALS['base'] ?>profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link<?= is_active('borrow.php') ?>" href="<?= $GLOBALS['base'] ?>borrow.php">My borrow</a></li>
          <li class="nav-item">
            <a
              id="btnLogout"
              class="nav-link"
              href="<?= e($GLOBALS['base']) ?>utils/login_regis_service/logout.php"
              data-redirect="<?= e($GLOBALS['base']) ?>login.php">Logout</a>
          </li>


        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<li class="nav-item">
  <a
    id="btnLogout"
    class="nav-link"
    href="<?= e($GLOBALS['base']) ?>utils/login_regis_service/logout.php"
    data-redirect="<?= e($GLOBALS['base']) ?>login.php">Logout</a>
</li>

<script>
  (function() {
    const a = document.getElementById('btnLogout');
    if (!a) return;

    a.addEventListener('click', async (e) => {
      e.preventDefault();
      a.classList.add('disabled');

      try {
        const res = await fetch(a.href, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'fetch'
          }
        });
        if (!res.ok) throw new Error('network');
        let ok = true;
        try {
          const data = await res.json();
          ok = !!data.ok;
        } catch (_) {}

        if (ok) {
          window.location.href = a.dataset.redirect + (a.dataset.redirect.includes('?') ? '&' : '?') + 'logged_out=1';
        } else {
          throw new Error('server');
        }
      } catch (err) {
        a.classList.remove('disabled');
        alert('Logout failed, please try again.');
      }
    });
  })();
</script>