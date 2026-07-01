<?php
if (!isset($_SESSION)) {
    session_start();
}

// 🚩 絕殺：把 Session 陣列完全清空
$_SESSION = array();

// 🚩 如果有使用 Cookie 記錄 Session ID，一併把 Cookie 清除（最標準安全的做法）
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// 🚩 徹底銷毀這份 Session
session_destroy();

// 轉址回首頁
$sPath = "../index.php";
header(sprintf("Location: %s", $sPath));
exit; // 🚩 記得養成好習慣，header 轉址後補上 exit 停止程式繼續執行