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
	<title>Phòng | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/room.css">
	<link rel="icon" href="/Image/favicon.ico">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="../PHP/trangchu.php">Trang chủ</a></li>
			<li>
				<a href="">Phòng</a>
				<ul class="sub-menu">
					<li><a href="../site/datphong.php">Đặt phòng</a></li>
					<li><a href="../site/doiphong.php">Đổi Phòng</a></li>
					<li><a href="../site/updatedatphong.php">Cập nhật ngày đi</a></li>
					<li><a href="../site/huydatphong.php">Hủy đặt phòng</a></li>

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
		
		<?php

		$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
			if(!$db){
			echo "Error : Unable to open database\n";
			}

		$sql = "select kh.makh, hoten, map, ngayden, ngaydi
				from khachhang kh, thuephong tp
				where kh.makh = tp.makh and thanhtoan = 0";
		$result = pg_query($db, $sql);			



		?>
		<div>
			<center><h2 class="ten">Danh sách phòng chưa thanh toán</h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" >
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã khách hàng</th>
			            <th>Họ và tên</th>
			            <th>Mã phòng</th>
			            <th>Ngày đến</th>
			            <th>Ngày đi</th>
			        </tr>
			        <tbody>
			        	<?php
			        		$b = 0;
			        		while ($row = pg_fetch_array($result)):
			        			$b = $b + 1;
			        			# code...

			        	?>
			        	<tr style="text-align: center; height: 30px;">

			                <td><?php echo "".$b."" ?></td>
			                <td><?php echo $row['makh']; ?></td>
			                <td><?php echo $row['hoten']; ?></td>
			                <td><?php echo $row['map']; ?></td>
			                <td><?php echo $row['ngayden']; ?></td>
			                <td><?php echo $row['ngaydi']; ?></td>
			                
			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center> 

		</div>
	</div>

</body>
</html>