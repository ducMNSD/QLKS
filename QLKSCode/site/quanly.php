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
    <title>Quản lý | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/QuanLy.css">
	<link rel="icon" href="/Image/favicon.ico">
</head>
<body>
	<div id="menu">
		<ul>
			<li>
				<a href="../site/khachhang.php">Khách hàng</a>
				<ul class="sub-menu">
					<li><a href="../site/timkiemkh.php">Tìm kiếm</a></li>
					<li><a href="../site/themkh.php">Thêm</a></li>
					<li><a href="../site/suakh.php">Chỉnh sửa</a></li>
					<li><a href="../site/xoakh.php">Xóa</a></li>
					<li><a href="../site/thongtincheckout.php">Thông tin check out</a></li>



					
				</ul>
			</li>
			<li>
				<a href="../site/phong.php">Phòng</a>
				<ul class="sub-menu">
					<li><a href="../site/timphong.php">Tìm kiếm</a></li>
					<li><a href="../site/themphong.php">Thêm</a></li>
					<li><a href="../site/suaphong.php">Chỉnh sửa</a></li>
					<li><a href="../site/xoaphong.php">Xóa</a></li>
				</ul>


			</li>
			<li>
				<a href="../site/dichvu.php">Dịch vụ</a>
				<ul class="sub-menu">
					<li><a href="../site/timdv.php">Tìm kiếm dịch vụ</a></li>
					<li><a href="../site/themdv.php">Thêm</a></li>
					<li><a href="../site/suadv.php">Chỉnh sửa</a></li>
					<li><a href="../site/xoadv.php">Xóa</a></li>
				</ul>


			</li>



			<li>
				<a href="../site/nv.php">Nhân viên</a>
				<ul class="sub-menu">
					<li><a href="../site/dangky.php">Tạo tài khoản mới</a></li>
					<li><a href="../site/suanv.php">Chỉnh sửa</a></li>
					<li><a href="../site/xoanv.php">Xóa</a></li>
				</ul>


			</li>
			<li>
				<a href="../site/hoadon.php">Hóa đơn</a>
				<ul class="sub-menu">

				</ul>


			</li>
			<li>
				<a href="">Thống kê</a>
				<ul class="sub-menu">
					<li><a href="../site/tkkh.php">Dành cho khách hàng</a></li>
					<li><a href="../site/tkphong.php">Dành cho phòng</a></li>
					<li><a href="../site/tkdichvu.php">Dành cho dịch vụ</a></li>
					<li><a href="../site/doanhthu.php">Doanh thu</a></li>

				</ul>

			</li>
			<li style="float: right">
				<a value ="<?php echo $hoten;?> "><?php echo "$hoten"; ?></a>
				<ul class="sub-menu">
					<li><a href="../PHP/logout.php" onclick="return confirm('Bạn đã chắc chắn')">Thoát</a></li>
				</ul>
			</li>

		</ul>
	</div>
	<div class="content" style="background-color: #D4D4D4;">
		<center><h2 style="padding-top: 20px; ">Hình ảnh phòng tham khảo: </h2></center>
		<div style="margin-top: 20px; margin-left: 20px;">

			<img src="../Image/room1.jpg" width="450px">
			<img src="../Image/room2.jpg" width="450px">
			<img src="../Image/room3.jpg" width="450px">
			<img src="../Image/room4.jpg" width="450px">


		</div>
		<center><h2 style="padding-top: 20px; ">Hình ảnh dịch vụ ăn uống tham khảo: </h2></center>
		<div style="margin-top: 20px; margin-left: 20px;">

			<img src="../Image/sv1.jpg" height="300px">
			<img src="../Image/sv2.jpg" height="300px">
			<img src="../Image/sv3.jpg" height="300px">
			<img src="../Image/sv4.jpg" height="300px">
			<img src="../Image/sv2.jpg" height="300px">
		</div>
		<center><h2 style="padding-top: 20px; ">Hình ảnh dịch vụ giải trí - thư giãn tham khảo: </h2></center>
		<div style="margin-top: 20px; margin-left: 20px;">
			<img src="../Image/sv5.jpg" width="450px">
			<img src="../Image/sv6.jpg" width="450px">
			<img src="../Image/sv7.jpg" width="450px">
			<img src="../Image/sv8.jpg" width="450px" height="300px">


			
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