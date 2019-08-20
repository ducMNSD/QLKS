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
<?php ob_start() ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Form đổi phòng | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/formdatphong.css">
	<link rel="icon" href="/Image/favicon.ico">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="../PHP/trangchu.php">Trang chủ</a></li>
			<li>
				<a href="../site/phong.php">Phòng</a>
				<ul class="sub-menu">
					<!-- <li><a href="../site/timkiemphong.php">Tìm kiếm</a></li> -->
					<!-- <li><a href="../site/datphong.php">Đặt phòng</a></li> -->
					<li><a href="../site/doiphong.php">Đổi Phòng</a></li>
				</ul>
			</li>


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
			<h2 class="title">Form đổi phòng</h2>
			<form class="login-form" method="POST">
				<div class="line">
					<input type="text" name="makh" placeholder="Mã khách hàng">
				</div>
				<div class="line">
					<input type="text" name="ngaydoi" placeholder="Ngày đổi">
				</div>
				<div class="line">
					<input type="text" name="mpcu" placeholder="Mã phòng cũ">
				</div>
				<div id="line-btn" class="line btnline">
					<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
					<?php
						$makh = $_POST['makh'];
						$mpmoi = $_REQUEST['ID'];
						$ngaydoi = $_POST['ngaydoi'];
						$mpcu = $_POST['mpcu'];
					?>
					<?php
						$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
						if(!$db){
							echo "Error : Unable to open database\n";
						}

						if (isset($_POST['hoantat'])) {

							if ($makh == '' || $mpcu == '' || $ngaydoi == '') {
								echo "Vui lòng nhập đầy đủ thông tin";
							}else{
								$sql = "insert into doiphong(makh, ngaydoi, mpcu, mpmoi) values ($makh, '$ngaydoi', '$mpcu', '$mpmoi');";
								$query = pg_query($db, $sql);
								if (!$query) {
									echo "Vui lòng nhập đúng thông tin !";
								}else
									echo "Thành công";
							}
						}


					?>
			
				</div>
				

				
			</form>
			
			
			


		</div>
	</div>


</body>
</html>