<!-- 商品詳細資訊 Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true" style="z-index: 1060 !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-info">
            <div class="modal-header border-info">
                <h5 class="modal-title text-info" id="productDetailName">商品載入中...</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="productDetailImg" src="" alt="" class="img-fluid rounded border border-secondary" style="max-height: 300px; object-fit: contain;">
                </div>
                <h4 class="text-warning mb-2" id="productDetailPrice"></h4>
                <div class="p-3 bg-secondary bg-opacity-25 rounded border border-info">
                    <h6>商品介紹：</h6>
                    <p id="productDetailp_detail" class="mb-0"></p>
                </div>
            </div>
            <div class="modal-footer border-info">
                <div class="input-group mb-3">
                    <input id="qty" type="number" class="form-control" aria-label="Recipient's username" aria-describedby="addCartFromDetail" value="1">
                    <button type="button" class="btn btn-info" id="addCartFromDetail">
                    <i class="fa-solid fa-cart-plus me-2"></i>
                </button>
                </div>
                
            </div>
        </div>
    </div>
</div>