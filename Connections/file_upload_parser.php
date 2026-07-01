<?php
$fileName = $_FILES['file1']['name'];
$fileTmpLoc = $_FILES['file1']['tmp_name'];
$fileType = $_FILES['file1']['type'];
$fileSize = $_FILES['file1']['size'];
$fileErrorMsg = $_FILES['file1']['error'];
$target_path = __DIR__ . "/../uploads/" . $fileName;

if (!$fileTmpLoc) {
    $retcode = array('success' => 'false', 'msg' => '', 'error' => '上傳檔案無法建立', 'fileName' => '');
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
if (move_uploaded_file($fileTmpLoc, $target_path)) {
    $retcode = array('success' => 'true', 'msg' => '完成檔案上傳', 'error' => '', 'fileName' => $fileName);
} else {
    $retcode = array('success' => 'false', 'msg' => '', 'error' => '上傳檔案無法建立', 'fileName' => '');
}
echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
exit();
