<style>
    /* 限制購物車內容區域高度 */
    #cartTableBody {
        display: block;
        /* 讓 tbody 變成區塊元素以限制高度 */
        max-height: 400px;
        /* 設定你想要的最大高度 */
        overflow-y: auto;
        /* 內容超過高度時顯示垂直捲軸 */
        overflow-x: hidden;
        /* 隱藏水平捲軸 */
    }

    /* 為了保持對齊，thead 也需要處理 */
    .table thead,
    .table tbody tr {
        display: table;
        /* 讓每一列維持表格佈局 */
        width: 100%;
        /* 寬度撐滿 */
        table-layout: fixed;
        /* 固定佈局，確保欄位對齊 */
    }

    .table thead {
        width: calc(100% - 1em);
        /* 預留捲軸寬度，防止標頭與內容錯位 */
    }

    /* 自定義滾動條樣式 (符合你的霓虹風格) */
    #cartTableBody::-webkit-scrollbar {
        width: 6px;
    }

    #cartTableBody::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    #cartTableBody::-webkit-scrollbar-thumb {
        background: var(--neon-blue, #00f2ff);
        /* 使用你定義的變數 */
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(0, 242, 255, 0.5);
    }

    /* 確保 tfoot 的 tr 也維持固定的表格佈局 */
    .table tfoot tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    /* 針對總計列的儲存格進行精準對齊 */
    #cartTableFoot .total-label {
        width: 66.66%;
        /* 對應前 4 欄 (圖片+商品+單價+數量) 的寬度比例 */
        text-align: right;
        padding-right: 20px;
    }

    #cartTableFoot .total-amount {
        width: 33.33%;
        /* 對應後 2 欄 (小計+刪除) 的寬度比例 */
        text-align: left;
    }
</style>

<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-info">
            <div class="modal-header border-info">
                <h5 class="modal-title text-info" id="cartModalLabel">
                    <i class="fa-solid fa-cart-shopping me-2"></i>我的購物車
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="cartListContent">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>圖片</th>
                                <th>商品</th>
                                <th>單價</th>
                                <th>
                                    <table>
                                        <tr>
                                            <th>數量</th>
                                            <th class="align-middle"><span class="d-inline-flex align-items-center justify-content-center"></span>更新</th>
                                        </tr>
                                    </table>
                                </th>
                                <th>小計</th>
                                <th class="align-middle">刪除</th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">

                        </tbody>
                        <tfoot id="cartTableFoot">

                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-info">
                <button type="button" class="btn btn-danger" onclick="deleteCartItem(2)">清空購物車</button>
                <button type="button" class="btn btn-info" onclick="showLoginModal('checkoutModal', '<?php echo isset($_SESSION['login']); ?>')">前往結帳</button>
            </div>
        </div>
    </div>
</div>