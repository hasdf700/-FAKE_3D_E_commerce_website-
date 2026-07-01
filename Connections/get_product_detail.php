<?php
require_once(__DIR__ . '/conn_db.php');
header('Content-Type: application/json; charset=utf-8');

// 取得傳入的商品 ID 與使用者的 IP
$p_id = isset($_GET['p_id']) ? intval($_GET['p_id']) : 0;
$u_ip = $_SERVER['REMOTE_ADDR'];

// 🚩 使用 LEFT JOIN 結合 product (p) 與 cart (c)
// p.* 代表抓取商品所有欄位，c.qty 代表抓取購物車中的數量
$sql = sprintf(
    "SELECT p.*, c.qty 
     FROM product p 
     LEFT JOIN cart c ON p.p_id = c.p_id 
     AND c.ip = '%s' 
     AND c.orderid IS NULL 
     WHERE p.p_id = %d", 
    $u_ip, 
    $p_id
);

$res = $link->query($sql);
$product = $res->fetch();

// if (isset($_GET['p_id'])) {
//     $p_id = intval($_GET['p_id']);
//     // 查詢單一商品的詳細資訊
//     $sql = sprintf("SELECT * FROM product,cart WHERE p_id = %d AND product.p_id = cart.p_id", $p_id);
//     $res = $link->query($sql);
//     $product = $res->fetch();
// }

if ($product) {
    echo json_encode([
        'status' => 'success',
        'data' => $product
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['status' => 'error', 'message' => '找不到商品資訊']);
}
