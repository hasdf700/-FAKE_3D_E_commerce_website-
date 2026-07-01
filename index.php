<?php
//如果session沒有啟，則啟動seesion功能，這是跨網頁變數存取
(!isset($_SESSION)) ? session_start() : "";
//這是將資料庫，連線程式載入
require_once('Connections/conn_db.php');
?>
<!DOCTYPE html>
<html lang="zh-Tw">

<head>
    <?php require_once("Connections/head.php"); ?>
</head>

<body>

    <div id="camera-label" style="display: none;">
        <span id="z-val">目前深度: -2500px</span><br>
    </div>
    <!-- 選單 -->
    <?php require_once("Connections/tech-menu.php"); ?>
    <!-- 商店詳細資訊+商品清單 Modal -->
    <?php require_once("Connections/product_Modal.php");
    ?>
    <!-- productdetail Modal -->
    <?php require_once("Connections/productdetail_Modal.php");
    ?>
    <!-- Cart Modal -->
    <?php require_once("Connections/cart_Modal.php"); ?>
    <!-- login Modal -->
    <?php require_once("Connections/login_Modal.php");
    ?>
    <!-- reigster Modal -->
    <?php require_once("Connections/reigster_Modal.php");
    ?>
    <!-- checkout Modal -->
    <?php require_once("Connections/checkout_Modal.php");
    ?>
    <!-- 主體 -->
    <div class="viewport">
        <div class="world" id="world">
            <?php //require_once("Connections/ground.php"); 
            ?>
            <?php //require_once("Connections/top-ceiling.php"); 
            ?>
            <?php //require_once("Connections/left-side.php"); 
            ?>
            <?php //require_once("Connections/store.php"); 
            ?>
            <?php //require_once("Connections/end-side.php"); 
            ?>
        </div>
    </div>


</body>
<!-- 3D介面控制 -->
<script>
    let startzPos = -3400;
    let zPos = startzPos;
    let targetZ = startzPos;

    const world = document.getElementById('world');
    const zDisplay = document.getElementById('z-val');

    // 1. 取得主畫面容器
    const viewport = document.querySelector('.viewport');

    function update() {
        zPos += (targetZ - zPos) * 0.3;
        world.style.transform = `translateZ(${zPos}px)`;
        if (zDisplay) {
            zDisplay.innerText = `目前深度: ${Math.round(zPos)}px`;
        }
        requestAnimationFrame(update);
    }
    // 2. 改為監聽 viewport 的滾輪事件，而不是 window
    if (viewport) {
        viewport.addEventListener('wheel', (e) => {
            // 只有當滑鼠在 viewport 範圍內捲動時，才會執行以下邏輯
            targetZ -= e.deltaY * 0.8;
            if (targetZ < startzPos) targetZ = startzPos;
            if (targetZ > -1680) targetZ = -1680;
        }, {
            passive: true
        });
    }
    requestAnimationFrame(update);
</script>

</html>