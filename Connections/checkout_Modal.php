<?php
//如果session沒有啟，則啟動seesion功能，這是跨網頁變數存取
(!isset($_SESSION)) ? session_start() : "";
//這是將資料庫，連線程式載入
require_once('conn_db.php');

if (isset($_SESSION['login']) == true) {
    $id = $_SESSION['emailid'];
} else {
    $id = '';
}

//取得收件者資料
$SQLstring = sprintf("SELECT * ,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND setdefault='1' AND addbook.myZip=town.Post AND town.AutoNo=city.AutoNO", $id);
$addbook_rs = $link->query($SQLstring);

if ($addbook_rs && $addbook_rs->rowCount() != 0) {
    $data = $addbook_rs->fetch();
    $cname = $data['cname'];
    $mobile = $data['mobile'];
    $myZip = $data['myZip'];
    $address = $data['address'];
    $ctName = $data['ctName'];
    $toName = $data['toName'];
} else {
    $cname = "";
    $mobile = "";
    $myZip = "";
    $address = "";
    $ctName = "";
    $toName = "";
}
?>

<style>
    /* 1. 預設沒選中的標籤樣式 */
    .pay-tab-btn {
        color: #6c757d !important;
        /* 沒選中時是暗灰色 text-muted */
        background-color: transparent !important;
        border: 1px solid transparent !important;
        border-bottom: 1px solid #6c757d !important;
        /* 讓沒選中的按鈕下方維持那條灰線 */
        margin-bottom: -1px !important;
        /* 關鍵：讓按鈕稍微往下壓 1px，蓋在 ul 的底線上 */
        border-top-left-radius: 0.375rem;
        /* 上左圓角 */
        border-top-right-radius: 0.375rem;
        /* 上右圓角 */
    }

    /* 2. 當標籤被選中 (Active) 時的融合樣式 */
    .pay-tab-btn.active {
        color: #0dcaf0 !important;
        /* 亮青色 text-info */
        background-color: #212529 !important;
        /* 與下方分頁同底色 bg-dark */

        /* 邊框設定：上、左、右是灰線，唯獨下方與底色相同 (#212529) */
        border-color: #6c757d #6c757d #212529 !important;

        /* 確保下邊框完全不顯示任何線條，達到連在一起的視覺效果 */
        border-bottom-color: #212529 !important;
    }
</style>
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-info shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-info" id="checkoutModalLabel">
                    <i class="fas fa-shopping-bag me-2"></i>NEXUSMALL：訂單結帳確認
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <h3 class="mb-4 text-center text-white fw-bold">會員結帳畫面</h3>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-secondary bg-opacity-25 border-info h-100 shadow-sm">
                            <div class="card-header border-info bg-transparent fw-bold" style="color:#0dcaf0;">
                                <i class="fas fa-truck fa-flip-horizontal me-2"></i>配送資訊
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-warning mb-3">收件人資訊：</h5>
                                <div class="ps-2">
                                    <h6 class="text-white mb-2">姓名：<?= $cname ?></h6>
                                    <p class="card-text mb-1 text-white"><i class="fas fa-phone-alt me-2"></i>電話：<?= $mobile ?></p>
                                    <p class="card-text mb-1 text-white"><i class="fas fa-map-marker-alt me-2"></i>郵遞區號：<?= $myZip ?> <?= $ctName ?><?= $toName ?></p>
                                    <p class="card-text mb-3 text-white">地址：<?= $address ?></p>
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#resetaddrsModal">選擇其他收件人</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-secondary bg-opacity-25 border-secondary h-100 shadow-sm">
                            <div class="card-header border-secondary bg-transparent fw-bold text-white">
                                <i class="fas fa-credit-card me-2"></i>支付方式
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs border-secondary flex-nowrap overflow-x-auto m-0" id="myTab" role="tablist" style="-webkit-overflow-scrolling: touch; white-space: nowrap;">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active fw-bold pay-tab-btn" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true" style="font-size:14pt">
                                            貨到付款
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-bold pay-tab-btn" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" style="font-size:14pt">
                                            信用卡
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fw-bold pay-tab-btn" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" style="font-size:14pt">
                                            銀行轉帳
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content bg-dark text-white border border-top-0 border-secondary p-4 rounded-bottom shadow-lg" id="myTabContent">

                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <h4 class="card-title text-info mb-4 fw-bold"><i class="fa-solid fa-address-card me-2"></i>收件人資訊：</h4>
                                        <div class="ps-3 border-start border-info border-3">
                                            <h5 class="card-title mb-3">姓名：<span class="text-info"><?php echo $cname; ?></span></h5>
                                            <p class="card-text mb-2 text-white-50">電話：<span class="text-white"><?= $mobile ?></span></p>
                                            <p class="card-text mb-2 text-white-50">郵遞區號：<span class="text-white"><?= $myZip ?> <?= $ctName ?><?= $toName ?></span></p>
                                            <p class="card-text mb-0 text-white-50">地址：<span class="text-white"><?= $address ?></span></p>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                        <table class="table table-dark table-hover table-borderless align-middle m-0">
                                            <caption class="text-info pt-0"><i class="fa-solid fa-circle-info me-1"></i>請選擇付款帳戶</caption>
                                            <thead class="border-bottom border-secondary">
                                                <tr class="text-info">
                                                    <th scope="col" width="10%">#</th>
                                                    <th scope="col" width="30%">信用卡系統</th>
                                                    <th scope="col" width="30%">發卡銀行</th>
                                                    <th scope="col" width="30%">信用卡號</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <input class="form-check-input border-info bg-dark" type="radio" name="creditCard" id="creditCard_1" checked>
                                                    </th>
                                                    <td><img src="images/Visa_Inc._logo.svg" alt="visa" style="max-height: 25px;" class="img-fluid bg-white p-1 rounded"></td>
                                                    <td>玉山商業銀行</td>
                                                    <td class="font-monospace text-info">1234 ****</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <input class="form-check-input border-info bg-dark" type="radio" name="creditCard" id="creditCard_2">
                                                    </th>
                                                    <td><img src="images/MasterCard_Logo.svg" alt="master" style="max-height: 25px;" class="img-fluid bg-white p-1 rounded"></td>
                                                    <td>玉山商業銀行</td>
                                                    <td class="font-monospace text-info">1234 ****</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <input class="form-check-input border-info bg-dark" type="radio" name="creditCard" id="creditCard_3">
                                                    </th>
                                                    <td><img src="images/UnionPay_logo.svg" alt="unionpay" style="max-height: 25px;" class="img-fluid bg-white p-1 rounded"></td>
                                                    <td>玉山商業銀行</td>
                                                    <td class="font-monospace text-info">1234 ****</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr class="border-secondary my-4">
                                        <button type="button" class="btn btn-outline-info"><i class="fa-solid fa-plus me-2"></i>使用其他信用卡付款</button>
                                    </div>

                                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                        <h4 class="card-title text-info mb-4 fw-bold"><i class="fa-solid fa-money-bill-transfer me-2"></i>ATM匯款資訊：</h4>
                                        <div class="row align-items-center">
                                            <div class="col-md-12 ps-md-4">
                                                <h5 class="card-title text-warning fw-bold mb-3">匯款銀行：台新銀行 (銀行代碼：812)</h5>
                                                <h5 class="card-title mb-2">戶名：<span class="text-info">李皇逸</span></h5>
                                                <p class="card-text mb-3 fs-5 font-monospace">匯款帳號：<mark class="bg-info text-dark px-2 rounded fw-bold">1234-4567-7890-1234</mark></p>
                                                <div class="alert alert-secondary bg-opacity-10 text-black-50 border-secondary small mb-0">
                                                    <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> 備註：匯款完成後，需要 1 至 2 個工作天。待系統入款完成後，系統將自動以mail通知訂單完成付款。
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                //建立結帳資料查詢
                $SQLstring = sprintf("SELECT * FROM cart,product WHERE ip='%s' AND orderid IS NULL AND cart.p_id=product.p_id ORDER BY cartid DESC", $_SERVER['REMOTE_ADDR']);
                $cart_rs = $link->query($SQLstring);
                $ptotal = 0;
                ?>
                <div class="table-responsive-md rounded-3 overflow-hidden border border-secondary">
                    <table class="table table-dark table-hover mb-0">

                        <tbody class="align-middle">
                            <tr class="table-primary text-dark fw-bold">
                                <th width="10%">圖片</th>
                                <th width="35%">名稱</th>
                                <th width="15%">價格</th>
                                <th width="10%">數量</th>
                                <th width="30%" class="text-end">小計</th>
                            </tr>
                            <?php while ($cart_data = $cart_rs->fetch()) { ?>
                                <tr>

                                    <td width="10%">

                                        <img src="images/<?= $cart_data['p_img'] ?>" alt="產品圖" class="img-fluid rounded border border-secondary" style="max-height: 50px;">
                                    </td>
                                    <td width="35%" class="small">
                                        <?= $cart_data['p_name'] ?>
                                    </td>
                                    <td width="15%" class="text-info fw-bold">
                                        <?= $cart_data['p_price'] ?>
                                    </td>
                                    <td width="10%">
                                        <?= $cart_data['qty'] ?>
                                    </td>
                                    <td width="30%" class="text-end text-warning fw-bold mb-0">
                                        $ <?= $cart_data['p_price'] * $cart_data['qty'] ?>
                                    </td>
                                </tr>
                            <?php $ptotal += $cart_data['p_price'] * $cart_data['qty'];
                            } ?>
                        </tbody>
                        <tfoot class="border-top border-secondary">
                            <tr>
                                <td colspan="4" class="text-end text-secondary py-2">累計：</td>
                                <td class="text-end py-0 text-white fw-bold h4">$ <?= $ptotal ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end text-secondary py-1">運費：</td>
                                <td class="text-end py-0 text-white fw-bold h4">$100</td>
                            </tr>
                            <tr class="table-active">
                                <td colspan="4" class="text-end text-danger fw-bold h4 py-3 mb-0">總計：</td>
                                <td class="text-end text-danger fw-bold py-0 mb-0 h3">$ <?= $ptotal + 100 ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-secondary bg-secondary bg-opacity-10 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" onclick="showCart()">返回修改</button>
                <button type="button" id="btnConfirmCheckout" name="btnConfirmCheckout" class="btn btn-danger btn-lg px-5 fw-bold shadow">
                    <i class="fas fa-cart-arrow-down me-2"></i>確認結帳
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 修改收件人modal -->
<?php
//取得收件人資料
$SQLstring = sprintf("SELECT *,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND addbook.myZip=town.Post AND town.AutoNo=city.AutoNo", $id);
$addbook_rs = $link->query($SQLstring);
?>
<div class="modal fade" id="resetaddrsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white border border-secondary shadow-lg">

            <div class="modal-header border-secondary">
                <h5 class="modal-title fs-5 text-info fw-bold" id="exampleModalLabel">
                    <i class="fa-solid fa-address-card me-2"></i>收件人資訊管理
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <form>
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="cname" id="cname" class="form-control bg-secondary bg-opacity-20 text-white border-secondary" placeholder="收件人姓名">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="mobile" id="mobile" class="form-control bg-secondary bg-opacity-20 text-white border-secondary" placeholder="收件人電話">
                        </div>
                        <div class="col-md-3">
                            <select name="myCitycheckout" id="myCitycheckout" class="form-select bg-secondary bg-opacity-20 text-white border-secondary">
                                <option value="" class="bg-dark text-white">請選擇市區</option>
                                <?php
                                $city = "SELECT * FROM `city` WHERE State=0";
                                $city_rs = $link->query($city);
                                while ($city_rows = $city_rs->fetch()) { ?>
                                    <option value="<?= $city_rows['AutoNo']; ?>" class="bg-dark text-white"><?= $city_rows['Name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="myTowncheckout" id="myTowncheckout" class="form-select bg-secondary bg-opacity-20 text-white border-secondary">
                                <option value="" class="bg-dark text-white">請選擇地區</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <input type="hidden" name="myZipcheckout" id="myZipcheckout" value="">
                            <label for="address" id="zipcodecheckout" name="add_label" class="text-info fw-bold mb-2">
                                <i class="fa-solid fa-map-pin me-1"></i>郵遞區號與詳細地址：
                            </label>
                            <input type="text" name="address" id="address" class="form-control bg-secondary bg-opacity-20 text-white border-secondary" placeholder="請輸入詳細道路地址">
                        </div>
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-info px-4 fw-bold" id="recipient" name="recipient">
                                <i class="fa-solid fa-plus me-2"></i>新增收件人
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="border-secondary my-4">

                <div class="table-responsive">
                    <table class="table table-dark table-hover table-borderless align-middle m-0">
                        <thead class="border-bottom border-secondary text-info fw-bold">
                            <tr>
                                <th scope="col" width="10%">#</th>
                                <th scope="col" width="25%">收件人姓名</th>
                                <th scope="col" width="25%">電話</th>
                                <th scope="col" width="40%">地址</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = $addbook_rs->fetch()) { ?>
                                <tr class="border-bottom border-secondary border-opacity-20">
                                    <th scope="row" width="10%">
                                        <input class="form-check-input border-info bg-dark" type="radio" name="gridRadios" id="gridRadios[]" value="<?= $data['addressid']; ?>" <?= ($data['setdefault']) ? 'checked' : ''; ?>>
                                    </th>
                                    <td width="25%" class="text-white fw-bold"><?= $data['cname']; ?></td>
                                    <td width="25%" class="text-white-50 font-monospace"><?= $data['mobile']; ?></td>
                                    <td width="40%" class="text-white-50"><?= $data['myZip'] . $data['ctName'] . $data['toName'] . $data['address']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer border-top border-secondary justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">關閉</button>
                <button type="button" class="btn btn-info text-dark px-4 fw-bold">確認選擇</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#myCitycheckout').change(function() {
            var CNo = $('#myCitycheckout').val();
            if (CNo == '') {
                return false;
            }
            $.ajax({
                url: 'Connections/Town_ajax.php',
                type: 'post',
                dataType: 'json',
                data: {
                    CNo: CNo
                },
                success: function(data) {
                    if (data.c == 1) {
                        $('#myTowncheckout').html(data.m);
                        $('#myZipcheckout').val("");
                        $('#zipcodecheckout').text("郵遞區號：");
                    } else {
                        alert(data.m);
                    }
                },
                error: function(data) {
                    alert('系統目前無法連接後台資料庫');
                }
            });
        });

        // 🚩 當鄉鎮選單改變時，自動抓取 data-zip 並寫入畫面
        $('#myTowncheckout').change(function() {
            // 抓取被選中的那個 option 的 data-zip 屬性
            var zip = $(this).find(':selected').data('zip');

            if (zip != '' && zip != undefined) {
                $('#myZipcheckout').val(zip); // 寫入隱藏欄位
                $('#zipcodecheckout').text("郵遞區號：" + zip); // 更新畫面的 Label 提示
            } else {
                $('#myZipcheckout').val("");
                $('#zipcodecheckout').text("郵遞區號：");
            }
        });

        // 新增收件人程式
        $('#recipient').click(function() {
            var validate = 0,
                msg = "";
            var cname = $("#cname").val();
            var mobile = $("#mobile").val();
            var myZip = $('#myZip').val();
            var address = $('#address').val();

            if (cname == "") {
                msg = msg + "收件人不得為空白！;\n";
                validate = 1;
            }
            if (mobile == "") {
                msg = msg + "電話不得為空白！;\n";
                validate = 1;
            }

            // 台灣手機號碼格式檢查正則表達式 (09開頭，後面接8個數字)
            var checkphone = /^[0]{1}[9]{1}[0-9]{8}$/;

            if (checkphone.test(mobile) == false) {
                msg = msg + "電話格式有誤！;\n";
                validate = 1;
            }
            if (myZip == "") {
                msg = msg + "郵遞區號不得為空白！;\n";
                validate = 1;
            }
            if (address == "") {
                msg = msg + "地址不得為空白！;\n";
                validate = 1;
            }
            if (validate) {
                alert(msg);
                return false;
            }
            $.ajax({
                url: 'addbook.php',
                type: 'post',
                datatype: 'json',
                data: {
                    cname: cname,
                    mobile: mobile,
                    myZip: myZip,
                    address: address
                },
                success: function(data) {
                    if (data.c == true) {
                        alert(data.m);
                        window.location.reload();
                    } else {
                        alert("Database response error：" + data.m);
                    }
                },
                error: function(data) {
                    alert("系統目前無法連接到後台資料庫");
                }
            });

        });
    });
</script>