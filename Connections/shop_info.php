<?php
require_once('conn_db.php');
header('Content-Type: application/json; charset=utf-8');
$shop = null;
$products = [];
if (isset($_GET['classid'])) {
    $classid = intval($_GET['classid']);
    // try {
    // 1. 查詢商店基本資訊
    $sql_shop = "SELECT sname, sdesc, sopening_Hours,scolseing_Hours FROM store WHERE classid = $classid";
    $res_shop = $link->query($sql_shop);
    $shop = $res_shop->fetch();

    // 2. 查詢該商店商品
    $sql_prod = "SELECT p_name, p_img, p_info, p_price, p_id FROM product WHERE classid = $classid AND p_open=1";
    $res_prod = $link->query($sql_prod);
    while ($p = $res_prod->fetch()) {
        $products[] = $p;
    }
    // } catch (Exception $e) {
    //     echo json_encode([
    //         'status' => 'error',
    //         'message' => $e->getMessage()
    //     ]);
    // }
} else if ($_GET['search_name']) {
    $search_name = $_GET['search_name'];
    // 2. 查詢該商店商品
    $sql_prod = sprintf("SELECT p_name, p_img, p_info, p_price FROM product WHERE p_name LIKE '%%%s%%'AND p_open=1", $search_name);
    $res_prod = $link->query($sql_prod);
    while ($p = $res_prod->fetch()) {
        $products[] = $p;
    }
}
// 3. 回傳 JSON (將 key 名稱與 JS 對齊)
echo json_encode([
    'status' => 'success',
    'sname' => $shop['sname'] ?? '搜尋中',
    'sdesc' => $shop['sdesc'] ?? '搜尋中',
    'sopening_Hours' => $shop['sopening_Hours'] ?? '??',
    'scolseing_Hours' => $shop['scolseing_Hours'] ?? '??',
    'products' => $products
]);
