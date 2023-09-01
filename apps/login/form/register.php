<div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Print<b>Station</b></a>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" action ="<?php print site_url('authen/login/check/register'); ?>" method="POST">
                    <div class="msg">สมัครสมาชิก</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้ภาษาอังกฤษ" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="อีเมล" required>
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
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="confirmPassword" placeholder="ยืนยันรหัสผ่าน" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">สมัครสมาชิก</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-12">
                        สมัครสมาชิกแล้ว, <a href="<?php print site_url('authen/login/form/regular'); ?>">ลงชื่อเข้าใช้</a>
                        </div>
                    </div>
                </form>
        
            </div>
        </div>
    </div>