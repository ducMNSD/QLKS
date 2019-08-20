<?php
session_start();
//tiến hành kiểm tra là người dùng đã đăng nhập hay chưa
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username'])) {
     header('Location: ../index.php');
}
$username = $_SESSION['username'];
$hoten = $_SESSION['hoten'];
$chucvu = $_SESSION['chucvu'];
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>Register | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/register.css">  
	<link rel="icon" href="/Image/favicon.ico">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="../PHP/trangchu.php">Trang chủ</a></li>
			<li style="float: right;">
				<a value ="<?php echo $hoten;?> "><?php echo "$hoten"; ?></a>
				<ul class="sub-menu">
					<li><a href="../PHP/logout.php" onclick="return confirm('Bạn đã chắc chắn')">Thoát</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="content">
		<div class="login-box">
			<h2 class="title">Đăng ký</h2>
			<form class="login-form" method="POST">
				<div id="line-account" class="line">
					<input type="text" name="username" placeholder="Tài khoản đăng ký">
				</div>
				<div id="password" class="line">
					<input type="password" name="password" placeholder="Mật khẩu đăng ký">
				</div>
				<div id="password" class="line">
					<input type="password" name="confirm" placeholder="Xác nhận mật khẩu">
				</div>
				<div id="line-account" class="line">
					<input type="text" name="fullname" placeholder="Họ tên">
				</div>
				<div class="line">
					<input type="text" name="gioitinh" placeholder="Giới tính: Nam hoặc Nữ">
				</div>
				<div class="line">
					<input type="text" name="sdt" placeholder="Số điện thoại">
				</div>
				<div id="line-btn" class="line btnline">
					<input type="submit" name="register" value="Đăng ký" class="btn">
					<?php

					$username = $_POST['username'];
					$password = $_POST['password'];
					$confirm = $_POST['confirm'];
					$hoten = $_POST['fullname'];
					$gioitinh = $_POST['gioitinh'];
					$sdt = $_POST['sdt'];
					$dbconn = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
					if (!$dbconn) {
						echo "Error : Unable to open database\n";
					}

					

					if(isset($_POST['register'])){
						$sql = "select * from quanly where username='$username'";
						$query = pg_query($sql);
						$num = pg_num_rows($query);

						if($username=='' || $password=='' || $confirm=='' || $hoten=='' || $gioitinh=='' || $sdt== '')
							echo "Vui lòng nhập đầy đủ thông tin";
						else if ($password != $confirm) {
							echo "Xác nhận mật khẩu không đúng";
							# code...
						}
						else if ($num > 0) {
							echo "Tài khoản đã tồn tại, vui lòng nhập lại";
							# code...
						}
						else{
							$sql1 = "insert into quanly values('$username','$password','$hoten','$gioitinh','Nhân viên','$sdt')";
							$query1 = pg_query($sql1);

						}
					}
					pg_free_result($query);
					pg_free_result($query1);
					pg_close($dbconn);



				?>
			
				</div>
				

				
			</form>
			
			
			


		</div>
	</div>



</body>
</html>