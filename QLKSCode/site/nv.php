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
	<title>Thông tin nhân viên | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/nv.css">
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
	<?php
		$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
		if(!$db){
			echo "Error : Unable to open database\n";
		}
								   
		$sql = "select * from quanly where chucvu='Nhân viên'";
		$result = pg_query($db, $sql);
	    	if(!$result)
	    		echo "Error: Truy van that bai\n";
	?>
	<div>
		<center><h2 class="ten">Danh sách nhân viên</h2></center>
		<center>
			<table  width="1200" border="1" style="border-collapse: collapse;">
		        <tr style="height: 50px;">
		            <th>STT</th>
		            <th>Tài khoản</th>
		            <th>Mật khẩu</th>
		            <th>Họ tên</th>
		            <th>Giới tính</th>
		            <th>Chức vụ</th>
		            <th>Số điện thoại</th>

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
		                <td><?php echo $row['username']; ?></td>
		                <td><?php echo $row['password']; ?></td>
		                <td><?php echo $row['hoten']; ?></td>
		                <td><?php echo $row['gioitinh']; ?></td>
		                <td><?php echo $row['chucvu']; ?></td>
		                <td><?php echo $row['sdt']; ?></td>


		                
		              

		            </tr>
        			<?php endwhile; ?>

		        </tbody>
		        
		    </table>   
	    </center> 

	</div>

</body>
</html>