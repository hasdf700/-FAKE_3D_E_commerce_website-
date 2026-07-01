<?php
header('Content-Type:application/json;charset=utf-8');
require_once(__DIR__ . '/conn_db.php');

$u_ip = $_SERVER['REMOTE_ADDR'];
$cart_items = [];

// 2. 查詢購物車內容 (JOIN product 取得名稱、圖片、價格)
// 我們篩選 ip 並確保 orderid IS NULL (代表還沒結帳)
$SQLstring = sprintf(
    "SELECT cart.cartid, cart.qty, product.p_id, product.p_name, product.p_price, product.p_img 
     FROM cart 
     INNER JOIN product ON cart.p_id = product.p_id 
     WHERE cart.ip='%s' AND cart.orderid IS NULL 
     ORDER BY cart.cartid DESC",
    $_SERVER['REMOTE_ADDR']
);
$cart_rs = $link->query($SQLstring);
while ($c = $cart_rs->fetch(PDO::FETCH_ASSOC)) {
    $cart_items[] = $c;
}
// 3. 回傳 JSON (將 key 名稱與 JS 對齊)
echo json_encode([
    'status' => 'success',
    'data' => $cart_items
]);
