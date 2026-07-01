<div class="modal fade" id="registerModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-info shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-info" id="registerModalLabel"><i class="fa-solid fa-user-plus me-2"></i>NEXUSMALL 會員註冊</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h2 class="fw-bold">建立帳號</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <form id="regForm" name="regForm" enctype="multipart/form-data" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-secondary border-info text-info"><i class="fa-solid fa-envelope"></i></span>
                                        <input type="email" name="email" id="reg_email" class="form-control bg-dark text-white border-info" placeholder="*請輸入 Email 帳號" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-secondary border-info text-info"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="pw1" id="pw1" class="form-control bg-dark text-white border-info" placeholder="*請輸入密碼" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-secondary border-info text-info"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="pw2" id="pw2" class="form-control bg-dark text-white border-info" placeholder="*再次確認密碼" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-secondary border-info text-info"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" name="cname" id="reg_cname" class="form-control bg-dark text-white border-info" placeholder="*請輸入姓名" required>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-secondary border-info text-info"><i class="fa-solid fa-phone"></i></span>
                                        <input type="text" name="mobile" id="reg_mobile" class="form-control bg-dark text-white border-info" required placeholder="請輸入手機號碼">
                                    </div>

                                    <div class="d-flex gap-2 mb-3">

                                        <select name="myCity" id="myCity" class="form-select bg-dark text-white border-info">
                                            <option value=''>選擇縣市</option>
                                            <?php
                                            $sql = "SELECT * FROM city WHERE State=0";
                                            $city = $link->query($sql);
                                            while ($city_rows = $city->fetch()) {
                                            ?>
                                                <option value="<?php echo $city_rows['AutoNo'] ?>"><?php echo $city_rows['Name'] ?></option>
                                            <?php } ?>
                                        </select>

                                        <select name="myTown" id="myTown" class="form-select bg-dark text-white border-info">
                                            <option value=''>選擇地區</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="reg_address" class="form-label text-info small mb-2" id="zipcode">郵遞區號：</label>

                                        <div class="input-group mb-3">
                                            <input type="hidden" name="myZip" id="myZip">

                                            <input type="text" name="address" id="reg_address" class="form-control bg-dark text-white border-info" placeholder="請輸入後續地址">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-secondary my-4">

                            <div class="row align-items-end">

                                <div class="col-md-7">
                                    <label class="form-label text-info small mb-2"><i class="fa-solid fa-camera me-1"></i>上傳個人照片圖示</label>
                                    <div class="input-group">
                                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control bg-dark text-white border-info" accept="image/x-png,image/jpeg,image/gif,image/jpg">
                                        <button type="button" class="btn btn-danger" id="uploadForm">開始上傳</button>
                                    </div>
                                    <div id="progress-div01" class="progress mt-2" style="display:none; height: 10px;">
                                        <div id="progress-bar01" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width:0%"></div>
                                    </div>
                                    <input type="hidden" name="uploadname" id="uploadname">
                                </div>

                                <div class="col-md-5">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="hidden" name="captcha" id="captcha" value=''>
                                        <a href="javascript:void(0);" onclick="getCaptcha();" title="換一張" class="bg-white rounded p-1">
                                            <canvas id="can" width="120" height="40"></canvas>
                                        </a>
                                        <input type="text" name="recaptcha" id="recaptcha" class="form-control bg-dark text-white border-info" placeholder="輸入驗證碼" required>
                                    </div>

                                </div>
                                <div class="mt-3 text-center">
                                    <img id="showing" src="" alt="預覽" style="display:none; max-height: 30px;" class="img-thumbnail bg-dark border-info">
                                </div>
                            </div>


                            <div class="text-center mt-5">
                                <input type="hidden" name="formctl" id="formctl" value="regForm">
                                <button type="submit" class="btn btn-info btn-lg px-5 fw-bold text-dark"><i class="fa-solid fa-paper-plane me-2"></i>確認送出註冊</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['formctl']) && $_POST['formctl'] == 'regForm') {
    $email = $_POST['email'];
    $pw1 = password_hash($_POST['pw1'], PASSWORD_BCRYPT);
    $cname = $_POST['cname'];

    $mobile = $_POST['mobile'];
    $myZip = $_POST['myZip'] == '' ? NULL : $_POST['myZip'];
    $address = $_POST['address'] == '' ? NULL : $_POST['address'];
    $imgname = $_POST['uploadname'] == '' ? 'avatar.svg' : $_POST['uploadname'];

    $insertsql = "INSERT INTO members (m_email,m_password,m_name,m_phone,m_img) VALUES ('" . $email . "','" . $pw1 . "','" . $cname . "','" . $mobile . "','" . $imgname . "')";

    $Result = $link->query($insertsql);

    if ($Result) {
        $emailid = $link->lastInsertId(); // 讀取剛新增會員編號

        $insertsql = "INSERT INTO addbook (emailid,setdefault,cname,mobile,myZip,address) VALUES ('" . $emailid . "','1','" . $cname . "','" . $mobile . "','" . $myZip . "','" . $address . "')"; // 將會員的姓名、電話、地址寫入addbook

        $Result = $link->query($insertsql);

        $_SESSION['login'] = true; // 設定會員註冊完直接登入，資料存SESSION
        $_SESSION['emailid'] = $emailid;
        $_SESSION['email'] = $email;
        $_SESSION['cname'] = $cname;
        $_SESSION['imgname'] = $imgname;

        echo "<script language='javascript'>alert('謝謝您，會員資料已完成註冊');location.href='index.php';</script>";
    } else {
        echo "<script language='javascript'>alert('註冊失敗，請重新註冊，並連絡管理員。');location.href='register.php';</script>";
    }
}
?>
<script type="text/javascript" src="jquery.validate.js"></script>

<script>
    //取得元素ID
    function getId(el) {
        return document.getElementById(el);
    }
    //圖示上傳處理
    $("#uploadForm").click(function(e) {
        var fileName = $('#fileToUpload').val();
        var idxDot = fileName.lastIndexOf(".") + 1;
        let extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
            $('#progress-div01').css("display", "flex");
            let file1 = getId("fileToUpload").files[0];
            let formdata = new FormData();
            formdata.append("file1", file1);

            let ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "Connections/file_upload_parser.php");
            ajax.send(formdata);
            return false;
        } else {
            alert("目前只支援jpg,jpeg,png,gif檔案格式上傳");
        }
    });
    //上傳過程顯示百分比
    function progressHandler(event) {
        let percent = Math.round((event.loaded / event.total) * 100);
        $("#progress-bar01").css("width", percent + "%");
        $("#progress-bar01").html(percent + "%");
    }
    //上傳完成處理顯示圖片
    function completeHandler(event) {
        let data = JSON.parse(event.target.responseText);
        if (data.success == 'true') {
            $('#uploadname').val(data.fileName);
            $('#showing').attr({
                'src': 'uploads/' + data.fileName,
                'style': 'display:block; max-height: 300px;'
            });
            $('button.btn.btn-danger').attr({
                'style': 'display:none;'
            });
        } else {
            alert(data.error);
        }
    }

    function errorHandler(event) {
        alert('Upload Failed: 上傳發生錯誤');
    }

    function abortHandler(event) {
        alert('Upload Failed: 上傳作業取消');
    }


    function getCaptcha() {
        var inputTxt = document.getElementById("captcha");
        inputTxt.value = captchaCode("can", 150, 50, "", "white", "28px", 5);
    }

    $(function() {
        getCaptcha();
        $('#myCity').change(function() {
            var CNo = $('#myCity').val();
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
                        $('#myTown').html(data.m);
                        $('#myZip').val("");
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
        $('#myTown').change(function() {
            // 抓取被選中的那個 option 的 data-zip 屬性
            var zip = $(this).find(':selected').data('zip');

            if (zip != '' && zip != undefined) {
                $('#myZip').val(zip); // 寫入隱藏欄位
                $('#zipcode').text("郵遞區號：" + zip); // 更新畫面的 Label 提示
            } else {
                $('#myZip').val("");
                $('#zipcode').text("0");
            }
        });
    });

    // 自訂手機格式驗證
    jQuery.validator.addMethod("checkphone", function(value, element, param) {
        var checkphone = /^[0]{1}[9]{1}[0-9]{8}$/;
        return this.optional(element) || (checkphone.test(value));
    });

    // 自訂郵遞區號驗證
    jQuery.validator.addMethod("checkMyTown", function(value, element, param) {
        return (value !== "");
    });

    //驗證form#reg表單
    $('#regForm').validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: 'Connections/checkemail.php'
            },
            pw1: {
                required: true,
                maxlength: 20,
                minlength: 4,
            },
            pw2: {
                required: true,
                equalTo: '#pw1'
            },
            cname: {
                required: true,
            },
            mobile: {
                required: true,
                checkphone: true,
            },
            address: {
                required: true,
            },
            myTown: {
                checkMyTown: true,
            },
            recaptcha: {
                required: true,
                equalTo: '#captcha',
            },
        },
        messages: {
            email: {
                required: 'email信箱不得為空白!!',
                email: 'email信箱格式有誤',
                remote: 'email信箱已經註冊'
            },
            pw1: {
                required: '密碼不得為空白!!',
                maxlength: '密碼最大長度為20位(4-20位英文字母與數字的組合)',
                minlength: '密碼最小長度為4位(4-20位英文字母與數字的組合)',
            },
            pw2: {
                required: '確認密碼不得為空白!!',
                equalTo: '兩次輸入的密碼必須一致！'
            },
            cname: {
                required: '使用者名稱不得為空白!!',
            },
            mobile: {
                required: '手機號碼不得為空白!!',
                checkphone: '手機號碼格式有誤',
            },
            address: {
                required: '地址不得為空白!!',
            },
            myTown: {
                checkMyTown: '需選擇郵遞區號',
            },
            recaptcha: {
                required: '驗證碼不得為空白!!',
                equalTo: '驗證碼需相同!!',
            },
        }
    });
</script>