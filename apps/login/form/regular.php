<div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Print<b>Station</b></a>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" action ="<?php print site_url('authen/login/check/login'); ?>" method="POST">
                    <div class="msg">ลงชื่อเข้าใช้</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">จำฉันไว้</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">ลงชื่อเข้าใช้</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="<?php print site_url('authen/login/form/register'); ?>">สมัครสมาชิก</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.html">ลืมรหัสผ่าน?</a>
                        </div>
                    </div>
                </form>
        
            </div>
        </div>
    </div>