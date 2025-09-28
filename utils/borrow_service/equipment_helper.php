<?php

function ui_stock_badge(int $left): string
{
    if ($left <= 0) return '<span class="badge bg-secondary">หมด</span>';
    if ($left <= 2) return '<span class="badge bg-warning text-dark">เหลือน้อย: ' . $left . '</span>';
    return '<span class="badge bg-success">คงเหลือ: ' . $left . '</span>';
}

function ui_img_or_default(?string $url, string $fallbackRel = 'assets/img/logo2.png'): string
{
    $url = trim((string)$url);
    return $url !== '' ? $url : $fallbackRel; // ถ้าต้องการ full URL ใช้ $GLOBALS['base'] ติดหน้า path ได้
}

?>