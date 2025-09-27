<?php
function e($v){ return htmlspecialchars((string)$v ?? '', ENT_QUOTES, 'UTF-8'); }

function is_active($file){
  return basename($_SERVER['PHP_SELF']) === $file ? ' active' : '';
}

/** เปิดหน้า: include <head>, header และเปิด <main> */
function page_start(string $title='N3 Sport'){
  $root   = dirname(__DIR__);                // .../n3-sport
  $assets = $root . '/assets';

  $GLOBALS['_page_title'] = $title;
  $GLOBALS['base'] = BASE_URL;

  require $assets . '/component/heading.php';
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
