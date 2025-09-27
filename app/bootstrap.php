<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/config.php';
date_default_timezone_set(TIMEZONE);

// บรรทัดนี้คือที่ error — ตอนนี้ไฟล์ helpers.php มีแล้วจะไม่พัง
require_once __DIR__ . '/helpers.php';
