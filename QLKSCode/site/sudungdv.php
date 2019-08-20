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
	<title>Dịch vụ | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/sudungdv.css">
	<link rel="icon" href="/Image/favicon.ico">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="../PHP/trangchu.php">Trang chủ</a></li>
			<li>
				<a href="../site/dichvu.php">Dịch vụ</a>

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
			<h2 class="title">Form sử dụng dịch vụ</h2>
			<form class="login-form" method="POST">
				<div class="line">
					<input type="text" name="makh" placeholder="Mã khách hàng">
				</div>
				<div class="line">
					<input type="text" name="madv" placeholder="Mã dịch vụ">
				</div>
				<div class="line">
					<input type="text" name="ngaysd" placeholder="Ngày sử dụng">
				</div>
				<div class="line">
					<input type="text" name="soluong" placeholder="Số lượng">
				</div>
				<div id="line-btn" class="line btnline">
					<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
					<?php

						$makh= $_POST['makh'];
						$madv = $_POST['madv'];
						$ngaysd = $_POST['ngaysd'];
						$soluong = $_POST['soluong'];
					?>
					<?php
						$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
						if (!$db) {
							echo "Error : Unable to open database\n";
						}

						

						if(isset($_POST['hoantat'])){

							$sql = "select * from sudungdv where makh = $makh and madv = '$madv' and ngaysd = '$ngaysd'";
							$query = pg_query($db, $sql);
							$num = pg_num_rows($query);

							if($makh=='' || $madv=='' || $ngaysd=='' || $soluong=='')
								echo "Vui lòng nhập đầy đủ thông tin";
							else if ($num > 0) {
								$sql1 = "select update_sl_sddv($makh,'$madv', '$ngaysd',$soluong)";
								$query1 = pg_query($db, $sql1);
								echo "Thành công";


							}
							else{
								$sql1 = "insert into sudungdv(makh, madv, ngaysd, soluong) values ($makh, '$madv', '$ngaysd', $soluong)";
								$query1 = pg_query($db, $sql1);
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