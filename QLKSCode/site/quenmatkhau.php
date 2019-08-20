<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>reset password | qlks.bk      </title>
    <meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="../CSS/quenmk.css">
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
	</div>
	<div class="content">
		<div class="login-box">
			<h2 class="title">Tìm mật khẩu</h2>
			<form class="login-form" method="POST">
				<div id="line-account" class="line">
					<input type="text" name="username" placeholder="Tài khoản đăng nhập">
				</div>
				<div class="line">
					<input type="text" name="sdt" placeholder="Số điện thoại">
				</div>
				<div id="line-btn" class="line btnline">
					<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
					<?php

						$username = $_POST['username'];
						$sdt = $_POST['sdt'];

					?>

					<?php

						$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
								   if(!$db){
								      echo "Error : Unable to open database\n";
								   }//ket noi database


						if(isset($_POST['hoantat'])){
							$sql = "select * from quanly where username='$username' and sdt='$sdt'";
							$query = pg_query($sql);
							$num_rows = pg_num_rows($query);
							if ($num_rows==0)
								echo "Tên đăng nhập hoặc số điện thoại không đúng, vui lòng thử lại !";
							else{
								$line = pg_fetch_row($query);
								echo "Mật khẩu là : $line[1]";
							}
						}

						pg_free_result($query);
						pg_close($db);

					?>
				</div>
				

				
			</form>
			
			
			


		</div>
	</div>



</body>
</body>
</html>