<?php
function e($v){ return htmlspecialchars((string)$v ?? '', ENT_QUOTES, 'UTF-8'); }

function is_active($file){
  return basename($_SERVER['PHP_SELF']) === $file ? ' active' : '';
}

/** เปิดหน้า: include <head>, header และเปิด <main> */
function page_start(string $title='N3 Sport'){
  $root   = dirname(__DIR__);
  $assets = $root . '/assets';

  $GLOBALS['_page_title'] = $title;
  $GLOBALS['base'] = BASE_URL;

  echo "<!DOCTYPE html>\n<html lang=\"en\">\n";
  require $assets . '/component/heading.php';  // <-- heading ไม่มี <html> แล้ว
  echo "<body>\n";
  require $assets . '/component/navbar.php';
  echo '<main id="content" class="container py-4">' . PHP_EOL;
}


/** ปิดหน้า: ปิด <main>, include footer และสคริปต์จำเป็น */
function page_end(){
  $root   = dirname(__DIR__);
  $assets = $root . '/assets';

  echo "</main>\n";
  require $assets . '/component/footer.php';

  echo <<<HTML
<script src="{$GLOBALS['base']}assets/js/layout-utils.js"></script>
<script>
  LayoutUtils.autoSpacing({header:'header', target:'content', extra:8, mode:'margin'});
</script>
</body>
</html>
HTML;
}

function flash_add(string $type, string $msg): void {
  if (session_status() === PHP_SESSION_NONE) session_start();
  $_SESSION['_flash'][] = ['type'=>$type, 'msg'=>$msg];
}

function flash_all(): array {
  if (session_status() === PHP_SESSION_NONE) session_start();
  $items = $_SESSION['_flash'] ?? [];
  unset($_SESSION['_flash']);
  return $items;
}

/** Render Bootstrap Alerts + icons + auto-dismiss */
function flash_render(bool $autoDismiss=true, int $delayMs=4000): void {
  $icons = [
    'success' => 'bi-check-circle',
    'danger'  => 'bi-x-circle',
    'warning' => 'bi-exclamation-triangle',
    'info'    => 'bi-info-circle',
  ];
  $items = flash_all();
  if (!$items) return;

  // กล่องรวม alerts (position: static ปกติ หรือจะไปวาง fixed เองก็ได้)
  echo '<div class="flash-stack">' . PHP_EOL;

  foreach ($items as $f) {
    $type = htmlspecialchars($f['type'], ENT_QUOTES, 'UTF-8');
    $msg  = htmlspecialchars($f['msg'],  ENT_QUOTES, 'UTF-8');
    $icon = $icons[$type] ?? 'bi-info-circle';

    echo <<<HTML
<div class="alert alert-{$type} alert-dismissible fade show d-flex align-items-center gap-2" role="alert" data-autodismiss="{$autoDismiss}" data-delay="{$delayMs}">
  <i class="bi {$icon} fs-5"></i>
  <div>{$msg}</div>
  <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
HTML;
  }
  echo '</div>' . PHP_EOL;

  // สคริปต์ auto-dismiss (ปิดเองหลัง delay)
  if ($autoDismiss) {
    echo <<<JS
<script>
  document.querySelectorAll('.alert[data-autodismiss="1"]').forEach(function(el){
    const delay = parseInt(el.getAttribute('data-delay')||'4000',10);
    setTimeout(function(){
      // ใช้ Bootstrap dismiss ถ้ามี
      if (window.bootstrap && bootstrap.Alert) {
        const a = bootstrap.Alert.getOrCreateInstance(el);
        a.close();
      } else {
        el.classList.remove('show');
        el.addEventListener('transitionend', ()=>el.remove(), {once:true});
      }
    }, delay);
  });
</script>
JS;
  }
}

function redirect_after_show_flash(string $to, int $delayMs = 1500, string $title = 'กำลังเปลี่ยนหน้า…', string $subtitle = ''): void {
  if (session_status() === PHP_SESSION_NONE) session_start();

  $toEsc   = htmlspecialchars($to, ENT_QUOTES, 'UTF-8');
  $title   = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
  $subtitle= htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8');
  $sec     = max(0, $delayMs) / 1000.0;

  // ปิด session lock ให้โหลดไว
  session_write_close();

  echo <<<HTML
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="{$sec}; url={$toEsc}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{$title}</title>
  <!-- ใช้ Bootstrap CDN ให้แสดง Alert ได้แน่ ๆ -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body{min-height:100vh;background:#f8fafc;display:grid;place-items:center;}
    .wrap{width:min(720px, 92%);}
    .spinner{margin:12px 0 4px 0}
  </style>
</head>
<body>
  <div class="wrap">
    <!-- แสดง Flash ตรงนี้ -->
HTML;
  // แสดง flash และเคลียร์ (consume) ที่นี่เลย
  flash_render(false); // autoDismiss=false ให้ผู้ใช้เห็นจนกว่าจะเปลี่ยนหน้า
  echo <<<HTML

    <div class="card border-0 shadow-sm mt-2">
      <div class="card-body text-center">
        <div class="spinner-border text-primary spinner" role="status" aria-hidden="true"></div>
        <h6 class="mb-1">{$title}</h6>
        <div class="text-muted small">{$subtitle}</div>
        <div class="text-muted small">จะไปยัง <code>{$toEsc}</code> ภายใน {$sec} วินาที…</div>
        <a class="btn btn-sm btn-primary mt-3" href="{$toEsc}">
          ไปต่อเลย <i class="bi bi-arrow-right-short"></i>
        </a>
      </div>
    </div>
  </div>

  <script>
    setTimeout(function(){ window.location.href = "{$toEsc}"; }, {$delayMs});
  </script>
</body>
</html>
HTML;
  exit;
}
