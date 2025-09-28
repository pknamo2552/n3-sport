<?php
// /app/db.php
function db(): mysqli {
  static $conn;

  if ($conn instanceof mysqli) return $conn;

  // mysql thrown error
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  $serverName   = 'localhost'; // or 127.0.0.1
  $userName     = 'root';
  $userPassword = '';
  $dbName       = 'n3_sport';

  $conn = new mysqli($serverName, $userName, $userPassword, $dbName);
  $conn->set_charset('utf8mb4'); // for emoji handle
  return $conn;
}
