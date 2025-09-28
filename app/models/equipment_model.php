<?php
// /app/models/equipment_model.php
require_once __DIR__ . '/../db.php';

/** Get all equipment */
function equipment_all(mysqli $db, string $q = ''): array {
  $q = trim($q);
  if ($q !== '') {
    $stmt = $db->prepare("
      SELECT id, name, description, image_url, stock
      FROM equipment
      WHERE name LIKE CONCAT('%', ?, '%')
         OR description LIKE CONCAT('%', ?, '%')
      ORDER BY id DESC
    ");
    $stmt->bind_param('ss', $q, $q);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $rows;
  }
  $res = $db->query("SELECT id, name, description, image_url, stock FROM equipment ORDER BY id DESC");
  return $res->fetch_all(MYSQLI_ASSOC);
}

/** Get spec equipment */
function equipment_find(mysqli $db, int $id): ?array {
  $stmt = $db->prepare("SELECT id, name, description, image_url, stock FROM equipment WHERE id=? LIMIT 1");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return $row ?: null;
}
