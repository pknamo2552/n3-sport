<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/config.php';
date_default_timezone_set(TIMEZONE);

require_once __DIR__ . '/helpers.php';
