<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8');
require_once(__DIR__ . '/conn_db.php');

if (isset($_GET['p_id']) && isset($_GET['qty'])) {
    $p_id = $_GET['p_id'];
    $qty = $_GET['qty'];
    $action = isset($_GET['action']) ? $_GET['action'] : 'add'; // 🚩 接收動作，預設為 add
    $msg='';
    $u_ip = $_SERVER['REMOTE_ADDR'];
    $query = sprintf("SELECT * FROM cart WHERE p_id=%d AND ip='%s' AND orderid IS NULL", $p_id, $u_ip);
    $result = $link->query($query);

    if ($result) {
        if ($result->rowCount() == 0) {
            $query = sprintf("INSERT INTO cart (p_id, qty, ip) VALUES (%d, %d, '%s')", $p_id, $qty, $u_ip);
            $msg = '新商品已增加至購物車。';
        } else {
            $cart_data = $result->fetch();

            if ($action == 'update') {
                // 🚩 模式 A：直接更新為前端傳來的數量
                $new_qty = $qty;
                $msg = '購物車數量已更新。';
            } else {
                // 🚩 模式 B：累加數量 (原本的邏輯)
                $new_qty = $cart_data['qty'] + $qty;
                $msg = '商品數量已累加至購物車。';
            }

            $query = sprintf("UPDATE cart SET qty=%d WHERE cartid=%d", $new_qty, $cart_data['cartid']);
        }
        $result = $link->query($query);
        $retcode = array("c" => "1", "m" => $msg);
    } else {
        $retcode = array("c" => "0", "m" => '抱歉資料無法寫入後台資料庫，請聯絡管理人員。');
    }

    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
