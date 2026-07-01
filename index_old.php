<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">

    <title>NEXUS MALL</title>
    <link rel="stylesheet" href="website_p01.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="webscripy_01.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</head>



<body>

    <div id="camera-label" style="display: none;">
        <span id="z-val">目前深度: -2500px</span><br>
    </div>
    <!-- 選單 -->
    <nav class="tech-menu">
        <div class="menu-item-l1"><i class="fas fa-microchip"></i>
            <ul class="submenu-l2">

                <li class="menu-item-l2"><i class="fa-solid fa-building"></i>
                    <ul class="submenu-l3">
                        <li><i class="fa-regular fa-building"></i> 10F</li>
                        <li><i class="fa-regular fa-building"></i> 9F</li>
                        <li><i class="fa-regular fa-building"></i> 8F</li>
                        <li><i class="fa-regular fa-building"></i> 7F</li>
                        <li><i class="fa-regular fa-building"></i> 6F</li>
                        <li><i class="fa-regular fa-building"></i> 5F</li>
                        <li><i class="fa-regular fa-building"></i> 4F</li>
                        <li><i class="fa-regular fa-building"></i> 3F</li>
                        <li><i class="fa-regular fa-building"></i> 2F</li>
                        <li><i class="fa-regular fa-building"></i> 1F</li>
                    </ul>
                </li>

                <li class="menu-item-l2"><i class="fa-solid fa-newspaper"></i>
                    <ul class="submenu-l3">
                        <li><i class="fa-regular fa-newspaper"></i> 最新消息</li>
                    </ul>
                </li>

                <li class="menu-item-l2"><i class="fa-solid fa-cart-shopping"></i>
                    <ul class="submenu-l3">
                        <li><i class="fa-solid fa-cart-shopping"></i> 購物車</li>
                        <li><i class="fa-solid fa-cart-shopping"></i> 直接結帳</li>
                    </ul>
                </li>
                <li class="menu-item-l2"><i class="fa-solid fa-user"></i>
                    <ul class="submenu-l3">
                        <li><i class="fa-brands fa-wpforms"></i> 訂單查詢</li>
                        <li><i class="fa-regular fa-user"></i> 會員專區</li>
                        <li><i class="fa-solid fa-heart"></i> 我的收藏</li>
                        <li><i class="fa-regular fa-user"></i> 登入會員</li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- 商店詳細資訊+商品清單 Modal -->
    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="shopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-dark text-light border-info">
                <!-- <div class="modal-header border-info">
                    <h5 class="modal-title" id="shopModalLabel">商店詳情</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div> -->
                <div class="modal-body">
                    <div class="row">
                        <!-- 左部分：招牌與商品列表 (col-md-8) -->
                        <div class="col-md-10 border-end border-secondary">
                            <!-- 模擬商店招牌 -->
                            <div class="modal-shop-signboard text-center p-4 mb-4"
                                style="background: rgba(0,0,0,0.5); border: 2px solid var(--neon-blue);">
                                <h2 id="modalSignboardName" class="glow-text m-0"></h2>
                            </div>

                            <h6>商品列表</h6>
                            <div id="modalProductList" class="row g-6">
                                <!-- 商品將由 JS 動態產生 -->
                            </div>
                        </div>
                        <!-- 右部分：店家資訊簡介 (col-md-4) -->
                        <div class="col-md-2">
                            <div class="p-2">
                                <h5 class="text-info"><i class="fa-solid fa-circle-info"></i> 店家簡介</h5>
                                <p id="modalShopDescription" class="mt-3" style="line-height: 1.8; color: #ccc;"></p>
                                <hr class="border-secondary">
                                <p><i class="fa-solid fa-location-dot text-info"></i> <strong>位置：</strong> 1F 樓層</p>
                                <p><i class="fa-solid fa-clock text-info"></i> <strong>營業時間：</strong> </p>
                                <p>10:00 - 22:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 主體 -->
    <div class="viewport">
        <div class="world" id="world">
            <div class="ground">
                <div class="floor-track"></div>
            </div>
            <div class="top-ceiling"></div>
            <!-- <div class="street-wall left-side">
                <div class="floor" id="left-side-2f"></div>
                <div class="floor" id="left-side-1f"></div>
            </div> -->
            <div class="street-wall right-side">
                <div class="floor" id="right-side-2f"></div>
                <div class="floor" id="right-side-1f"> </div>
            </div>
            <div class="end-side">
                <div class="endfloor">
                    <div class="shop" style="width: 100%;height: 3200px;">
                        <div class="clockArea">
                            <div class="digtal-clock">
                                <span class="num-slot" id="t0">0</span><span class="num-slot" id="t1">0</span>
                                <span class="divider">:</span>
                                <span class="num-slot" id="t2">0</span><span class="num-slot" id="t3">0</span>
                                <span class="divider">:</span>
                                <span class="num-slot" id="t4">0</span><span class="num-slot" id="t5">0</span>
                            </div>
                        </div>
                        <div class="carousel-wrapper">
                            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                        aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                        aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="images/pic1.webp" class="d-block w-100" alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="images/pic2.webp" class="d-block w-100" alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="images/pic3.webp" class="d-block w-100" alt="">
                                    </div>
                                </div>

                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
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
            }, { passive: true });
        }
        requestAnimationFrame(update);
    </script>
    <!-- 時鐘控制 -->
    <Script>
        document.getElementsByTagName('body')[0].onload = function () {
            clockUpdate();
            interval = setInterval(clockUpdate, 1000);
        }
        function clockUpdate() {
            var date = new Date();
            var h = addZero(date.getHours());
            var m = addZero(date.getMinutes());
            var s = addZero(date.getSeconds());
            timeString = `${h}${m}${s}`;
            for (i = 0; i < 6; i++) {
                document.getElementById('t' + i).innerText = timeString[i];
            }
        }
    </Script>
    <!-- 生成店面 -->
    <script>
        renderShops1F('left-side-1f');
        renderShops1F('right-side-1f');
    </script>
</body>

</html>