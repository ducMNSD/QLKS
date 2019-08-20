<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
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

<?php

	if ($chucvu == "Quản lý") {
		header('Location: ../site/quanly.php');
		# code...
	}
	else
		header('Location: ../site/nhanvien.php');
?>


</body>
</html>