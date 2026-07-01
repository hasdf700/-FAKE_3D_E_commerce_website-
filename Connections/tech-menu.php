<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<nav class="tech-menu">
    <div class="menu-item-l1"><i class="fas fa-microchip"></i>
        <ul class="submenu-l2">
            <li class="menu-item-l2"><i class="fa-solid fa-building"></i>
                <ul class="submenu-l3">
                    <?php
                    // 1. 取得總店數
                    $sql_total = "SELECT COUNT(*) as total FROM store WHERE sopen=1";
                    $res_total = $link->query($sql_total);
                    $row_total = $res_total->fetch();
                    $total_stores = $row_total['total'];

                    // 2. 定義一層樓幾間店
                    $max_per_floor = 4;

                    // 3. 計算總共會有幾層樓 (無條件進位)
                    $total_floors = ceil($total_stores / $max_per_floor);
                    // 4. 取得當前要看哪一樓，預設為 1F
                    $current_floor = 1;
                    if (isset($_GET['floor']) && $_GET['floor'] > 0) {
                        $current_floor = intval($_GET['floor']);
                    }

                    // 從最高樓層往回跑迴圈到 1 樓
                    for ($f = $total_floors; $f >= 1; $f--) {
                        // 增加一個 active 樣式判斷，讓使用者知道現在在幾樓
                        $activeClass = ($f == $current_floor) ? 'color: yellow;' : 'color: white;';
                        $activeClassPos = ($f == $current_floor) ? '<i class="fa-solid fa-user ms-3"></i>' : '';
                    ?>
                        <li>
                            <a href="?floor=<?php echo $f; ?>" style="<?php echo $activeClass; ?>text-decoration: none; display: block; width: 100%;">
                                <i class="fa-regular fa-building"></i><?php echo '  ' . $f; ?>F<?php echo $activeClassPos; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="menu-item-l2"><i class="fa-solid fa-magnifying-glass"></i>
                <ul class="submenu-l3">
                    <div class="input-group">
                        <input type="text" class="form-control shop-search-input" aria-label="Example text with button addon" aria-describedby="button-addon1" placeholder="Search..." value="<?php echo (isset($_GET['search_name'])) ? $_GET['search_name'] : '' ?>" style="color: black !important;" onkeyup="if(event.keyCode==13) showShopDetail(this.value);" required>
                        <button class="btn btn-outline-secondary" type="button" id="button-addon1" onclick="document.querySelector('.shop-search-input').value"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </ul>
            </li>
            <li class="menu-item-l2"><i class="fa-solid fa-newspaper"></i>
                <ul class="submenu-l3">
                    <li><i class="fa-regular fa-newspaper"></i> 最新消息</li>
                </ul>
            </li>
            <?php
            //讀取後購物車內產品數量
            $SQLstring = "SELECT * FROM cart WHERE orderid is NULL AND ip='" . $_SERVER['REMOTE_ADDR'] . "'";
            $cart_rs = $link->query($SQLstring);
            ?>
            <li class="menu-item-l2">
                <i class="fa-solid fa-cart-shopping">
                    <span id="cart-count" class='position-absolute translate-middle badge rounded-pill text-bg-info'><?php echo ($cart_rs) ? $cart_rs->rowCount() : ''; ?></span>
                </i>
                <ul class="submenu-l3">
                    <li onclick="showCart()"><i class="fa-solid fa-cart-shopping"><span id="cart-count" class='position-absolute translate-middle badge rounded-pill text-bg-info'><?php echo ($cart_rs) ? $cart_rs->rowCount() : ''; ?></span></i> 購物車</li>
                    <li onclick="showLoginModal('checkoutModal', '<?php echo isset($_SESSION['login']); ?>')">
                        <i class="fa-solid fa-cart-shopping"></i> 直接結帳
                    </li>
                </ul>
            </li>
            <li class="menu-item-l2"><i class="fa-solid fa-user"></i>
                <ul class="submenu-l3">
                    <li><i class="fa-brands fa-wpforms"></i> 訂單查詢</li>
                    <li><i class="fa-regular fa-user"></i> 會員專區</li>
                    <li><i class="fa-solid fa-heart"></i> 我的收藏</li>

                    <?php if (isset($_SESSION['login']) == true) { ?>
                        <li><a href="Connections/logout.php" style="text-decoration: none;color: inherit;"><i class="fa-regular fa-user"></i> 登出會員</a></li>
                    <?php } else { ?>
                        <li onclick="showLoginModal('loginModal')"><i class="fa-regular fa-user"></i> 登入會員</li>
                    <?php } ?>

                    <li onclick="showLoginModal('registerModal')"><i class="fa-regular fa-user"></i> 註冊會員</li>

                </ul>
            </li>
        </ul>
    </div>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const techMenu = document.querySelector('.tech-menu');

        // 🚩 使用事件委派 (Event Delegation)，這樣不管是選單還是 Modal 裡的 input 都能被監聽到
        document.addEventListener('focusin', function(event) {
            // 判斷焦點是否進入了帶有 .shop-search-input 的框
            if (event.target.classList.contains('shop-search-input')) {
                // 找到該 input 最近的父層 L2 項目 (僅選單內的才有)
                const searchMenuItemL2 = event.target.closest('.menu-item-l2');

                if (searchMenuItemL2) {
                    techMenu.classList.add('keep-open');
                    searchMenuItemL2.classList.add('keep-open-l3');
                }
            }
        });

        document.addEventListener('focusout', function(event) {
            if (event.target.classList.contains('shop-search-input')) {
                const searchMenuItemL2 = event.target.closest('.menu-item-l2');

                if (searchMenuItemL2) {
                    techMenu.classList.remove('keep-open');
                    searchMenuItemL2.classList.remove('keep-open-l3');
                }
            }
        });
    });
</script>