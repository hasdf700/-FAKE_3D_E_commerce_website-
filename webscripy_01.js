//紀錄現在商店
let current_open_classid = null;
// 記錄modal頁面的來源：'shop' 或 'cart'
let product_detail_source = null;


//個位數增加0的一個小函數
function addZero(x) {
    return x < 10 ? '0' + x : x;
}

//彈出 produclist_Modal 並填充資料的函數
function showShopDetail(param, source = 'shop') {
    current_open_classid = param;
    product_detail_source = source;
    // --- 🚩 新增：清空輸入框 ---
    $('.shop-search-input').val('').blur();

    // --- 🚩 新增：處理已存在的 Modal ---
    closeAllModals();

    let requestData = {};
    // 🚩 判斷傳入參數的類型
    if (typeof param == 'number' || !isNaN(param)) {
        // 如果是數字，代表傳入的是 classid
        requestData = { classid: param };
    } else {
        // 如果是字串，代表傳入的是搜尋關鍵字
        requestData = { search_name: param };
    }

    $.ajax({
        url: 'Connections/shop_info.php',
        type: 'GET',
        data: requestData,
        dataType: 'json',
        success: function (data) {
            if (data.status === 'error') {
                alert("伺服器錯誤: " + data.message);
                return;
            }
            // 1. 填充店家基本資訊 (這裡使用 sname 對應 PHP)
            $('#modalSignboardName').text(data.sname);
            $('#modalShopDescription').text(data.sdesc);

            $('#sopening_Hours').text(addZero(data.sopening_Hours));
            $('#scolseing_Hours').text(addZero(data.scolseing_Hours));

            // 2. 清空並重新填充商品列表
            let productHtml = '';
            if (data.products && data.products.length > 0) {
                $.each(data.products, function (index, p) {
                    productHtml += `
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 bg-secondary bg-opacity-25 border-info text-white">
                                <img src="images/${p.p_img}" class="card-img-top" alt="${p.p_name}" style="height:150px; object-fit:contain; cursor: pointer;" onclick="showProductDetail(${p.p_id}, 'shop')">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-info">${p.p_name}</h5>
                                    <p class="card-text small text-secondary">${p.p_info}</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-warning">$${p.p_price}</span>
                                        <div>
                                            <button class="btn btn-sm btn-outline-warning" onclick="showProductDetail(${p.p_id}, 'shop')">詳細資訊</button>
                                            <button class="btn btn-sm btn-outline-info" onclick="addcart(${p.p_id})">加入購物車</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });
            } else {
                productHtml = '<p class="text-center w-100 text-muted">目前暫無商品</p>';
            }
            $('#modalProductList').html(productHtml);

            // 3. 顯示 Modal
            var myModal = new bootstrap.Modal(document.getElementById('shopModal'));
            myModal.show();
        },
        error: function (xhr, status, error) {
            console.log("原始回傳內容 (Debug):", xhr.responseText);
            alert("無法載入商店資料，JSON 解析失敗。");
        }
    });
}
//彈出 cart_Modal 並填充資料的函數
function showCart() {
    // 檢查是否已經有開啟中的 Modal (例如商店 Modal)，有的話先關閉
    closeAllModals();

    $.ajax({
        url: '/NEXUSMall/Connections/getcart.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let html = '';
                let htmlfoot = '';
                let totalSum = 0;

                // 2. 判斷是否有商品資料
                if (response.data && response.data.length > 0) {
                    $.each(response.data, function (index, item) {
                        // 計算該項商品小計 (單價 * 數量)
                        let subtotal = item.p_price * item.qty;
                        totalSum += subtotal;

                        // 🚩 生成表格列，對應你的資料庫欄位 p_img, p_name, p_price, qty
                        html += `
                            <tr>
                                <td>
                                    <img src="images/${item.p_img}" alt="${item.p_name}" style="height:50px; width:50px; object-fit:contain; cursor: pointer;" onclick="showProductDetail(${item.p_id}, 'cart')">
                                </td>
                                <td class="align-middle" style="cursor: pointer;" onclick="showProductDetail(${item.p_id}, 'cart')">${item.p_name}</td>
                                <td class="align-middle">$${item.p_price}</td>

                                <td class="align-middle">                                  
                                    <table>
                                        <tr>
                                            <td>${item.qty}</td>
                                            <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-outline-info d-inline-flex align-items-center justify-content-center m-0 p-0" style="width: 32px; height: 32px;" onclick="showProductDetail(${item.p_id}, 'cart')">
                                            <i class="fa-solid fa-rotate"></i>
                                            </button>
                                            </td>
                                        </tr>
                                    </table>                                
                                </td>
                                
                                <td class="align-middle text-info">$${subtotal}</td>
                           
                                <td>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteCartItem(1, ${item.cartid})">
                                    <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                                
                            </tr>`;
                    });

                    //F 3. 加上總計列
                    htmlfoot = `
                                <tr class="fw-bold table-active">
                                    <td class="total-label text-white">總計</td>
                                    <td class="total-amount text-warning">$${totalSum}</td>
                                </tr>
                            `;
                } else {
                    html = '<tr><td colspan="6" class="text-center text-muted">購物車內暫無商品</td></tr>';
                }

                // 4. 填入資料並顯示 Modal
                $('#cartTableBody').html(html);
                $('#cartTableFoot').html(htmlfoot);
                const myCartModal = new bootstrap.Modal(document.getElementById('cartModal'));
                myCartModal.show();
            }
        },
        error: function () {
            alert("載入購物車失敗，請確認後端連線。");
        }
    });
}
//刪除商品
function deleteCartItem(mode, cartid = 0) {
    let confirmMsg = (mode == 1) ? "確認刪除此商品？" : "確認清空購物車？";
    if (confirm(confirmMsg)) {
        $.ajax({
            url: '/NEXUSMall/Connections/delcart.php',
            type: 'GET',
            data: { mode: mode, cartid: cartid },
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {
                    // 🚩 重點：刪除成功後，重新呼叫一次 showCart()，讓 Modal 內容自動刷新！
                    // 不要讓使用者感覺到網頁重整
                    showCart();
                    updateCartBadge(); // 🚩 執行更新
                } else {
                    alert(response.msg);
                }
            },
            error: function () {
                alert("系統錯誤，無法刪除。");
            }
        });
    }
}
//加入購物車
function addcart(p_id) {
    var qty = $("#qty").val();
    if (qty <= 0) {
        alert("產品數量不得為0或是負數，請在修改數量!");
        return (false);
    } else {
        qty = qty;
    }
    var current_action = (product_detail_source == 'cart') ? 'update' : 'add';

    $.ajax({
        url: '/NEXUSMALL/Connections/addcart.php',
        type: 'get',
        data: {
            p_id: p_id,
            qty: qty,
            action: current_action
        },
        dataType: 'json', // 明確指定 JSON 格式
        success: function (data) {
            if (data.c == true) {
                alert(data.m);
                $('#qty').val(1);
                updateCartBadge(); // 🚩 執行更新

                const productModal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
                if (productModal) {
                    productModal.hide();
                }

                // 🚩 根據來源回加載對應的 Modal
                if (product_detail_source == 'cart') {
                    showCart(); // 回到購物車清單
                } else if (product_detail_source == 'shop' && current_open_classid !== null) {
                    showShopDetail(current_open_classid); // 回到商店詳細
                }

                //window.location.reload();
            } else {
                alert(data.m);
            }
        },
        error: function (data) {
            console.log("PHP Error:", data.responseText);
            alert("系統目前無法連接到後台資料庫。");
        }
    });
}

//建立更新購物車數字的函式
function updateCartBadge() {
    $.ajax({
        url: '/NEXUSMall/Connections/get_cart_count.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {

                $('.badge').text(response.count > 0 ? response.count : '');
            }
        }
    });
}
//彈出商品詳細介紹
function showProductDetail(p_id, source = 'shop') {
    // 🚩 記住這次是從哪裡打開的
    product_detail_source = source;

    const productModal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
    if (productModal) {
        productModal.hide();
    }
    $.ajax({
        url: '/NEXUSMall/Connections/get_product_detail.php',
        type: 'GET',
        data: { p_id: p_id },
        dataType: 'json',
        success: function (response) {
            if (response.status == 'success') {
                const p = response.data;
                // 填入資料
                $('#productDetailName').text(p.p_name);
                $('#productDetailImg').attr('src', 'images/' + p.p_img);
                $('#productDetailPrice').text('$' + p.p_price);
                $('#productDetailp_detail').text(p.p_detail || '暫無詳細介紹');


                const qty = $('#qty');
                // 🚩 動態調整按鈕文字與功能
                const btn = $('#addCartFromDetail');

                if (source == 'cart') {
                    qty.val(p.qty);
                    btn.html('<i class="fa-solid fa-rotate me-2"></i>更新數量');
                    btn.off('click').on('click', function () {
                        addcart(p.p_id); // 執行更新函式
                    });
                } else {
                    qty.val(1);
                    btn.html('<i class="fa-solid fa-cart-plus me-2"></i>加入購物車');
                    btn.off('click').on('click', function () {
                        addcart(p.p_id);
                    });
                }

                // 綁定「加入購物車」按鈕的點擊事件
                $('#addCartFromDetail').off('click').on('click', function () {
                    addcart(p.p_id); // 呼叫你原本寫好的 addcart 函式
                });
                // 顯示 Modal
                const pModal = new bootstrap.Modal(document.getElementById('productModal'));
                pModal.show();
            } else {
                alert(response.message);
            }
        },
        error: function () {
            alert("無法取得商品詳細資訊。");
        }
    });
}
//秀出modal
function showLoginModal(targetModalId, isLoggedIn) {
    // 1. 先關閉目前畫面上所有可能開啟的 Modal，維持畫面乾淨
    closeAllModals();

    // 2. 核心邏輯：如果點擊的是結帳，但卻沒有登入
    if (targetModalId === 'checkoutModal' && !isLoggedIn) {
        console.log('偵測到未登入，強制改彈出登入視窗');

        // 抓取你的登入 Modal (請確保 ID 對應你的登入 Modal)
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    } else {
        // 3. 正常狀況：已登入，或是該 Modal 不需要登入權限，直接開啟目標
        const targetModal = new bootstrap.Modal(document.getElementById(targetModalId));
        targetModal.show();
    }
}

// 萬用函式：一次關閉網頁上所有開啟的 Modal
function closeAllModals() {
    // 1. 尋找畫面上所有帶有 .show 類別的 modal
    $('.modal.show').each(function () {
        // 2. 取得該元素的 Bootstrap Modal 實例
        var modalInstance = bootstrap.Modal.getInstance(this);

        // 3. 如果實例存在，就執行隱藏
        if (modalInstance) {
            modalInstance.hide();
        }
    });

    // 🚩 防呆保險：強制移除可能殘留的黑幕背景與網頁鎖定狀態
    setTimeout(function () {
        $('.modal-backdrop').remove(); // 移除所有的黑幕遮罩
        $('body').css('overflow', ''); // 回復網頁原本的滾動功能
        $('body').removeClass('modal-open'); // 移除 Bootstrap 鎖定網頁滾動的 class
    }, 300); // 延遲 300 毫秒（等 Bootstrap 內建的淡出動畫跑完）
}