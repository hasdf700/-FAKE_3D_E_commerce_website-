<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8');
require_once(__DIR__ . '/conn_db.php');

$sql = sprintf("SELECT * FROM town WHERE AutoNo=%d", $_POST['CNo']);
$town = $link->query($sql);
$town_n = $town->rowCount();
$htmlstring = "<option value=''>選擇鄉鎮市</option>";
if ($town_n > 0) {
    while ($town_rs = $town->fetch()) {

        $zip = isset($town_rs['Post']) ? $town_rs['Post'] : '';
        $htmlstring .= "<option value='" . $town_rs['townNo'] . "' data-zip='" . $zip . "'>" . $town_rs['Name'] . "</option>";
    }
    $retcode = array("c" => 1, "m" => $htmlstring);
} else {
    $retcode = array("c" => 0, "m" => '找不到相關資料');
}
echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
return;
