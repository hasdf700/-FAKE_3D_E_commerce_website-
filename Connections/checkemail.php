<?php
// 引入資料庫連線
include_once("conn_db.php");

// jQuery Validate 預設會用 GET 發送該欄位名稱 (例如：?email=xxx@gmail.com)
if (isset($_GET['email'])) {
    $email = trim($_GET['email']);

    // 🚩 修正點：確保資料表名稱為 members，且欄位名稱一致（假設皆為 m_email）
    // 使用 quote() 確保 SQL 安全，避免單引號破壞語法
    $query = sprintf("SELECT `m_email` FROM `members` WHERE `m_email` = %s", $link->quote($email));

    $result = $link->query($query);

    if ($result) {
        $row = $result->rowCount();

        if ($row == 0) {
            // 筆數為 0，代表此信箱「沒有重複」，可以使用！
            echo "true";
            exit;
        }
    }
}

// 預設或有重複、報錯時，皆回傳 false，代表「信箱已重複或不可使用」
echo "false";
exit;
