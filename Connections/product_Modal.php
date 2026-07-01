<div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="shopModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="width: 100%;">
        <div class="modal-content bg-dark text-light border-info">
            <!-- <div class="modal-header border-info">
                    <h5 class="modal-title" id="shopModalLabel">商店詳情</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div> -->
            <div class="modal-body">
                <div class="row">
                    <!--店家資訊簡介 (col-md-2) -->
                    <div class="col-md-2 border-end border-secondary">
                        <div class="p-2">
                            <h5 class="text-info"><i class="fa-solid fa-circle-info"></i> 店家簡介</h5>
                            <p id="modalShopDescription" class="mt-3" style="line-height: 1.8; color: #ccc;"></p>
                            <hr class="border-secondary">
                            <p><i class="fa-solid fa-clock text-info"></i><strong> 營業時間：</strong></p>
                            <p>
                                <span id="sopening_Hours">00</span>
                                <span>: 00</span>
                                <span> - </span>
                                <span id="scolseing_Hours">00</span>
                                <span>: 00</span>
                            </p>
                            <hr class="border-secondary">
                            <div class="input-group">
                                <input type="text" class="form-control shop-search-input" aria-label="Example text with button addon" aria-describedby="button-addon1" placeholder="Search..." value="<?php echo (isset($_GET['search_name'])) ? $_GET['search_name'] : '' ?>" style="color: black !important;" onkeyup="if(event.keyCode==13) showShopDetail(this.value)" required>
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1" onclick="document.querySelector('.shop-search-input').value"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>
                    </div>
                    <!--招牌與商品列表 (col-md-10) -->
                    <div class="col-md-10">
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
                </div>
            </div>
        </div>
    </div>
</div>