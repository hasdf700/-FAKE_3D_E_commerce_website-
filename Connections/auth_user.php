<?php
// 🚩 修正 CORS 衝突：當 withCredentials 為 true 時，Origin 必須指定具體網址，不能用 *
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}
header('Access-Control-Allow-Credentials: true'); // 🚩 必須搭配這行，前端 Session 才會生效
header('Content-Type: application/json; charset=utf-8');

(!isset($_SESSION)) ? session_start() : "";
require_once('conn_db.php');

// 🚩 關鍵修正：先初始化 response 陣列，避免 PHP 8 報 Undefined variable 錯誤
$response = [
    'success' => false,
    'msg' => ''
];

$email    = isset($_POST['email']) ? trim($_POST['email']) : null;
$password = isset($_POST['password']) ? trim($_POST['password']) : null;

if (empty($email) || empty($password)) {
    $response['msg'] = '請輸入電子信箱與密碼';
    echo json_encode($response);
    exit;
}

try {
    $sql = "SELECT `m_id`, `m_email`, `m_password`, `m_name`, `m_img`, `m_status` FROM `members` WHERE `m_email` = :email LIMIT 1";
    $stmt = $link->prepare($sql);
    $stmt->execute([':email' => $email]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($member) {
        if (intval($member['m_status']) === 0) {
            $response['msg'] = '此帳號已被停權，請聯絡管理員';
            echo json_encode($response);
            exit;
        }

        if (password_verify($password, $member['m_password'])) {
            $_SESSION['login'] = true;
            $_SESSION['emailid'] = $member['m_id'];
            $_SESSION['email'] = $member['m_email'];
            $_SESSION['cname'] = $member['m_name'];
            $_SESSION['imgname'] = $member['m_img'];

            $response['success'] = true;
            $response['msg'] = '登入成功！';
        } else {
            $response['msg'] = '電子信箱或密碼錯誤';
        }
    } else {
        $response['msg'] = '電子信箱或密碼錯誤';
    }
} catch (PDOException $e) {
    $response['msg'] = '資料庫錯誤：' . $e->getMessage();
}

echo json_encode($response);
exit;
