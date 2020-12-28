<?php
header('Content-Type: text/html; charset=utf-8');
 $setup_file="system/include/setup.cfg.php";
if(file_exists($setup_file)){
    print "ระบบได้ทำการติดตั้งเรียบร้อยแล้ว";
    print "<a href=\"./\">กลับสู่หน้าหลัก</a>";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <script src="system/jquery/jquery-3.4.1.min.js"></script>
  <title>การติดตั้งระบบงานกิจกรรม</title>
  <style>
	  #content,
.login,
.login-card a,
.login-card h1,
h3,
.login-help {
	text-align: center
}

body,
html {
	margin: 0;
	padding: 0;
	width: 100%;
	height: 100%;
	display: table
}

#content {
	font-family: 'Designil Font', 'Helvetica', sans-serif;
	/*background:url(captiveportal-background_1.jpg) center center no-repeat fixed;opacity: 0;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;display:table-cell;vertical-align:middle*/
}

.login-card {
	padding: 40px;
	width: 274px;
	background-color: rgba(255, 255, 255, .8);
	margin: 0 auto 10px;
	border-radius: 2px;
	box-shadow: 0 2px 2px rgba(0, 0, 0, .3);
	overflow: hidden
}

.login-card h3 {
	font-weight: 200;
	font-size: 1.5em;
	color: #1383c6
}

h1 {
	font-weight: 400;
	font-size: 2.3em;
	color: #1383c6
}

.login-card h1 span {
	color: #f26721
}

.login-card img {
	width: 50%;
	height: 50%
}

.login-card input[type=submit] {
	width: 100%;
	display: block;
	margin-bottom: 10px;
	position: relative
}

.login-card input[type=text],
input[type=password] {
	height: 44px;
	font-size: 16px;
	width: 100%;
	margin-bottom: 10px;
	-webkit-appearance: none;
	background: #fff;
	border: 1px solid #d9d9d9;
	border-top: 1px solid silver;
	padding: 0 8px;
	box-sizing: border-box;
	-moz-box-sizing: border-box
}
.login-card select {
	height: 44px;
	font-size: 16px;
	width: 100%;
	margin-bottom: 10px;
	-webkit-appearance: none;
	background: #fff;
	border: 1px solid #d9d9d9;
	border-top: 1px solid silver;
	padding: 0 8px;
	box-sizing: border-box;
	-moz-box-sizing: border-box
}

.login-card input[type=text]:hover,
input[type=password]:hover {
	border: 1px solid #b9b9b9;
	border-top: 1px solid #a0a0a0;
	-moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
	-webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
	box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1)
}

.login {
	font-size: 14px;
	font-family: Arial, sans-serif;
	font-weight: 700;
	height: 36px;
	padding: 0 8px
}

.login-submit {
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	border: 0;
	color: #fff;
	text-shadow: 0 1px rgba(0, 0, 0, .1);
	background-color: #4d90fe
}

.login-check {
	height: 44px;
	font-size: 16px;
	width: 100%;
	margin-bottom: 10px;
	-webkit-appearance: none;
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	border: 0;
	color: #fff;
	text-shadow: 0 1px rgba(0, 0, 0, .1);
	background-color: #fe904d
}

.login-submit:disabled {
	opacity: .6
}

.login-submit:hover {
	border: 0;
	text-shadow: 0 1px rgba(0, 0, 0, .3);
	background-color: #357ae8
}

.login-card a {
	text-decoration: none;
	color: #222;
	font-weight: 400;
	display: inline-block;
	opacity: .6;
	transition: opacity ease .5s
}

.login-card a:hover {
	opacity: 1
}

.login-help {
	width: 100%;
	font-size: 12px
}

.list {
	list-style-type: none;
	padding: 0
}

.list__item {
	margin: 0 0 .7rem;
	padding: 0
}

label {
	display: -webkit-box;
	display: -webkit-flex;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	-webkit-align-items: center;
	-ms-flex-align: center;
	align-items: center;
	text-align: left;
	font-size: 14px;
}

input[type=checkbox] {
	-webkit-box-flex: 0;
	-webkit-flex: none;
	-ms-flex: none;
	flex: none;
	margin-right: 10px;
	float: left
}

@media screen and (max-width:450px) {
	.login-card {
		width: 70%!important
	}
	.login-card img {
		width: 30%;
		height: 30%
	}
}
  </style>
</head>

<body bgcolor="#AACCFF">
<div id="content">
	<div class="login-card">
		<img src="images/logopnut.png"/><br>
 		<h3>การติดตั้งระบบงานกิจกรรม</h3>
	  <form name="setup_form" method="post" action="install.php">
		<input type="text" name="site_url" placeholder="Home URL" id="site_url" required>
		<input type="text" name="db_server" placeholder="Database server" id="db_server" value="localhost" required>
		<input type="text" name="db_user" placeholder="Database user" id="db_user" value="root" required>
		<input type="text" name="db_password" placeholder="Database password" id="db_password">
		<input type="text" name="db_name" placeholder="Database name" id="db_name" required>
		<input type="text" name="tb_prefix" placeholder="table prefix" id="tb_prefix" value="sa_">
		<input type="text" name="rms_url" placeholder="ระบุลิงก์ไปยังระบบ RMS" id="rms_url" required>
		<button class="login login-check" type="button" id="chk_url">ตรวจสอบ URL</button>
		<select name="school_id" disabled>
	  		<option value="00">เลือกสถานศึกษา</option>
		</select>
		<input type="submit" name="continue" class="login login-submit" value="ดำเนินการต่อ" id="continue" disabled>
	  </form>
	</div>
</div>
</body>
<script>
    var cur_url=window.location.href;
    document.getElementById("site_url").value =cur_url.substring(0,cur_url.length-9);
$("#chk_url").click(function(){
	alert("555");
});
    </script>
</html>
