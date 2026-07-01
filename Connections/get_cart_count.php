<?php
require_once(__DIR__ . '/conn_db.php');
header('Content-Type: application/json; charset=utf-8');

$u_ip = $_SERVER['REMOTE_ADDR'];

// 查詢該 IP 且未結帳的商品數量總計
$sql = sprintf("SELECT COUNT(*) as total FROM cart WHERE ip='%s' AND orderid IS NULL", $u_ip);
$res = $link->query($sql);
$data = $res->fetch();

echo json_encode([
    'status' => 'success',
    'count' => (int)$data['total']
]);
