<?php $loggedIn = !empty($_SESSION['username']); ?>
<!-- Alert -->
 
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
          <li class="nav-item"><a class="nav-link<?= is_active('borrow.php') ?>" href="<?= $GLOBALS['base'] ?>borrow.php">My borrow</a></li>
          <li class="nav-item"><a class="nav-link<?= is_active('profile.php') ?>" href="<?= $GLOBALS['base'] ?>profile.php">Profile</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>