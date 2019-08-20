<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
    <title>Login | qlks.bk      </title>
    <meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="/CSS/login.css">
	<link rel="icon" href="/Image/favicon.ico">
</head>

<body>
	<div class="header">
		<div class="langWrapper">
			<select class="lang">
				<option value="vi-VN">Việt Nam - Tiếng Việt</option>
				<option value="en-SG">Singapore - English</option>


			</select>
			<span class="earth-icon"></span>
		</div>
		<div></div>


	</div>
	<div class="content">
		<div class="login-box">
			<h2 class="title">Đăng nhập</h2>
			<form id="login-form" class="login-form" method="POST"> 
				<div id="line-account" class="line">
					<input type="text" name="username" placeholder="Tài khoản đăng nhập">
				</div>
				<div id="password" class="line">
					<input type="password" name="password" placeholder="Mật khẩu đăng nhập">
				</div>
				<div id="line-btn" class="line btnline">
					<input type="submit" name="login" value="Đăng nhập" class="btn">
					<?php

						$username = $_POST['username'];
						$password = $_POST['password'];

					?>

					<?php

						$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
								   if(!$db){
								      echo "Error : Unable to open database\n";
								   }//ket noi database


						if(isset($_POST['login'])){
							$sql = "select * from quanly where username='$username' and password='$password'";
							$query = pg_query($db,$sql);
							while($row = pg_fetch_array($query)){
								$hoten = $row["hoten"] ;
								$chucvu = $row["chucvu"];
							}
							$num_rows = pg_num_rows($query);
							if ($num_rows==0)
								echo "Tên đăng nhập hoặc mật khẩu không đúng, vui lòng thử lại !";
							else{
								$_SESSION['username'] = $username;
								$_SESSION['hoten'] = $hoten;
								$_SESSION['chucvu'] = $chucvu;
								if($chucvu == "Quản lý"){
									header('Location: ../site/quanly.php');
								}
								else
									header('Location: ../site/nhanvien.php');
							}
						}

						pg_free_result($query);
						pg_close($db);

					?>
				</div>
				<!-- <div class="divider">
					<span>hoặc</span>
				</div>
				<div id="line-btn" class="line btnline1">
					<input type="submit" name="dangky" value="Tạo tài khoản mới" class="btn">
					<?php
						if(isset($_POST['dangky']))
							header('Location: /site/dangky.php');




					?>
				</div> -->
			</form>
			<div class="linkline">
				<a href="../site/quenmatkhau.php">Quên mật khẩu ?</a>
			</div>

		</div>
		
	</div>
	<div class="footer">
			<div class="title-bottom">
					<p>Email: dinhson2905@gmail.com</p>
					<p>Điện thoại: 0964971583</p>
			</div>
	</div>
		


	
</body>
</html>
