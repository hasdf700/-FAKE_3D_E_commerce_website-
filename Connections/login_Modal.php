<style>
    /* 登入輸入框聚焦時的發光效果 */
    .form-signin .form-control:focus {
        background-color: #2b3035 !important;
        color: #fff !important;
        border-color: #0dcaf0 !important;
        box-shadow: 0 0 10px rgba(13, 202, 240, 0.5) !important;
    }

    /* 登入按鈕懸停效果 */
    .btn-signin:hover {
        background-color: #0bacce !important;
        box-shadow: 0 0 15px rgba(13, 202, 240, 0.7);
        color: #000 !important;
    }

    /* 連結懸停效果 */
    .other a:hover {
        text-decoration: underline !important;
    }
</style>
<div class="modal fade" id="loginModal" $tabindex="-1" $ aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-info">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="loginModalLabel"><i class="fa-solid fa-user-shield me-2 text-info"></i>安全登入</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mycard mycard-container text-center">
                    <p id="profile-name" class="profile-name-card fw-bold fs-5 text-info">NEXUSMALL：會員登入</p>

                    <form class="form-signin" id="form1">
                        <div class="mb-3 text-start">
                            <label for="inputAccount" class="form-label text-secondary">帳號 (Email)</label>
                            <input type="email" id="inputAccount" name="inputAccount" class="form-control bg-secondary text-white border-info" placeholder="name@example.com" required autofocus />
                        </div>
                        <div class="mb-3 text-start">
                            <label for="inputPassword" class="form-label text-secondary">密碼 (Password)</label>
                            <input type="password" id="inputPassword" name="inputPassword" class="form-control bg-secondary text-white border-info" placeholder="Password" required />
                        </div>
                        <button type="submit" class="btn btn-info w-100 fw-bold text-dark mt-3 py-2 btn-signin">Sign in</button>
                    </form>

                    <div class="other mt-4 text-center">
                        <a href="register.php" class="text-decoration-none text-warning me-2">New user</a>
                        <span class="text-secondary">/</span>
                        <a href="#" class="text-decoration-none text-secondary ms-2">Forgot the password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loading" name="loading" style="display:none; position:fixed; width:100%; height:100%; top:0; left:0; background-color:rgba(0,0,0,.7); z-index:9999;">
    <div style="position:absolute; top:50%; left:50%; transform: translate(-50%, -50%);" class="text-info text-center">
        <i class="fas fa-spinner fa-spin fa-5x fa-fw mb-2"></i>
        <div class="fw-bold">驗證中，請稍候...</div>
    </div>
</div>
<script>
    $(function() {
        $("#form1").submit(function(e) {
            e.preventDefault(); // 🚩 記得阻止表單預設跳轉行為

            const inputAccount = $("#inputAccount").val();
            const inputPassword = $("#inputPassword").val();


            $("#loading").show();
            $.ajax({
                url: '/NEXUSMall/Connections/auth_user.php',
                type: 'post',
                dataType: 'json',
                data: {
                    // 🚩 關鍵修正：把 Key 改成跟後端 $_POST 相同的名稱
                    email: inputAccount,
                    password: inputPassword
                },
                success: function(data) {
                    if (data.success == true) {
                        alert(data.msg);
                        window.location.href = "index.php";
                    } else {
                        alert(data.msg);
                    }

                },
                error: function(xhr, status, error) {
                    // 🚩 Debug 提示：這樣如果失敗才能在 Console 看到真正原因
                    console.log("AJAX失敗原因:", error);
                    alert("系統目前無法連接到後台資料庫");
                }
            });
        });
    });
</script>