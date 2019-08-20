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
    <title>Xóa phòng | qlks.bk</title>
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
			<h2 class="title">Form Xóa phòng</h2>
			<form class="login-form" method="POST">
				<div id="line-account" class="line">
					<input type="text" name="map" placeholder="Mã phòng">
				</div>
				<div id="line-btn" class="line btnline">
					<input type="submit" name="register" value="Xác nhận" class="btn" onclick="return confirm('Bạn đã chắc chắn')">
					<?php

					$map = $_POST['map'];
					$dbconn = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
					if (!$dbconn) {
						echo "Error : Unable to open database\n";
					}

					

					if(isset($_POST['register'])){
						if ($map == '') {
							echo "Vui lòng nhập đầy đủ thông tin";
						}else{

							$sql = "select * from thuephong where map = '$map' and thanhtoan = 0";
							$query = pg_query($dbconn, $sql);
							$num_rows = pg_num_rows($query);

							if ($num_rows == 0) {
								$sql1 = "update phong set trangthai = 0 where map = '$map'";
								$query1 = pg_query($dbconn, $sql1);

								if (!$query1) {
									echo "Xóa phòng không thành công .";
								}else
									echo "Đã xóa thành công.";
							
								
							}else
								echo "Phòng đang đưọc sử dụng không đưọc chỉnh sửa.";


							
						}
					}
					pg_free_result($query);
					pg_close($dbconn);



				?>
			
				</div>
				

				
			</form>
			
			
			


		</div>
	</div>



</body>
</html>