<?php
require_once(__DIR__ . '/conn_db.php');
header('Content-Type: application/json; charset=utf-8');

$res = ["status" => false, "msg" => "刪除失敗"];

if (isset($_GET['mode']) && $_GET['mode'] != '') {
    $mode = intval($_GET['mode']);

    switch ($mode) {
        case 1:
            $cartid = intval($_GET['cartid']);
            $SQLstring = sprintf("DELETE FROM cart WHERE cartid=%d AND orderid IS NULL", $cartid);
            break;
        case 2:
            $u_ip = $_SERVER['REMOTE_ADDR'];
            $SQLstring = sprintf("DELETE FROM cart WHERE ip='%s' AND orderid IS NULL", $u_ip);
            break;
    }

    if ($link->query($SQLstring)) {
        $res = ["status" => true, "msg" => "資料已刪除"];
    }
}

echo json_encode($res);
return;