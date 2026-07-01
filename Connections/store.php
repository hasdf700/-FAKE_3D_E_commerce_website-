<div class="street-wall right-side">
    <div class="floor" id="right-side-2f"></div>
    <div class="floor d-flex justify-content-end" id="right-side-1f">
        <!-- 引入商店 -->
        <div class="shop" style="z-index:10;">
            <div class="signboard">
                <div class="top-light"></div>
                <h1 class="glow-text">裝飾用1</h1>
                <div class="bottom-light"></div>
            </div>
            <div class="doorway">
                <img src="images/store/store_Test01.webp" alt="裝飾用">
            </div>
        </div>
        <?php
        //建立商店rs
        $maxRows_rs = 4;
        $floorNum_rs = 0;
        // 1. 取得當前樓層，預設為 1F
        if (isset($_GET['floor'])) {
            $floorNum_rs = $_GET['floor'] - 1;
        }
        $startRow_rs = $floorNum_rs * $maxRows_rs;
        //商品資料查詢
        $queryFirst = "SELECT * FROM store WHERE sopen=1 ORDER BY sort ASC";
        $query = sprintf("%s LIMIT %d,%d", $queryFirst, $startRow_rs, $maxRows_rs);
        $sList01 = $link->query($query);
        $i = 1;
        ?>
        <?php while ($sList01_Rows = $sList01->fetch()) { ?>
            <div class="shop" onclick="showShopDetail(<?php echo $sList01_Rows['classid']; ?>)" style="z-index:10; cursor:pointer;">
                <div class="signboard">
                    <div class="top-light"></div>
                    <h1 class="glow-text"><?php echo $sList01_Rows['sname']; ?></h1>
                    <div class="bottom-light"></div>
                </div>
                <div class="doorway">
                    <div class="hint-container">
                        <div class="click-hint">Enter</div>
                        <!-- <i class="fa-solid fa-square-arrow-up-right"></i> -->
                    </div>
                    <img src="images/<?php echo $sList01_Rows['img_file']; ?>" alt="<?php echo $sList01_Rows['sname']; ?>">
                </div>
            </div>
        <?php $i++;
        } ?>
        <div class="shop" style="z-index:10;">
            <div class="signboard">
                <div class="top-light"></div>
                <h1 class="glow-text">裝飾用</h1>
                <div class="bottom-light"></div>
            </div>
            <div class="doorway">
                <img src="images/store/store_Test01.webp" alt="裝飾用">
            </div>
        </div>
        <div class="shop" style="z-index:10;">
            <div class="signboard">
                <div class="top-light"></div>
                <h1 class="glow-text">裝飾用</h1>
                <div class="bottom-light"></div>
            </div>
            <div class="doorway">
                <img src="images/store/store_Test02.webp" alt="裝飾用">
            </div>
        </div>
    </div>
</div>