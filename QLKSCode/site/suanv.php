
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
    <title>Sửa nhân viên | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/insertkh.css">
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
	<div class="container">
		<div class="themkh-menu">
			<center>
				<h2 class="title">Form sửa nhân viên</h2>
				<form class="themkh-form" method="POST">
					<div class="line">
						<input type="text" name="taikhoan" placeholder="Tài khoản">
					</div>
					<div class="line">
						<input type="text" name="matkhau" placeholder="Mật khẩu">
					</div>
					<div class="line">
						<input type="text" name="hoten" placeholder="Họ và tên">
					</div>
					
					<div class="line">
						Giới tính:
						<select name="gioitinh">
							<option>Nam</option>
							<option>Nữ</option>
							<option>Khác</option>

						</select>
					</div>
					<div class="line">
						<input type="text" name="sdt" placeholder="Số điện thoại">
					</div>
					

					<div id="line-btn" class="line btnline">
						<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
					</div>
				</form>
			</center>								
		</div>
	<?php
		$taikhoan = $_POST['taikhoan'];
		$matkhau = $_POST['matkhau'];
		$hoten = $_POST['hoten'];
		$gioitinh = $_POST['gioitinh'];
		$sdt = $_POST['sdt'];


		$dbconn = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
		if (!$dbconn) {
			echo "Error : Unable to open database\n";
		}

						

		if(isset($_POST['hoantat'])){
			if ($hoten == '' || $sdt == '' || $gioitinh == '' || $matkhau == '' || $taikhoan == '') {
				echo "Vui lòng nhập đầy đủ thông tin";
			}else{
				$sql = "update quanly set hoten = '$hoten', password = '$matkhau', sdt = '$sdt', gioitinh = '$gioitinh' where username = '$taikhoan'";
				$query = pg_query($dbconn, $sql);
				if (!$query) {
					echo "Vui lòng nhập đúng thông tin !";
				}else{
					$sql1 = "select * from quanly where username = '$taikhoan'";
					$result = pg_query($dbconn, $sql1);
				}
			}
		}
		pg_free_result($query);
		pg_close($dbconn);
	?>
				


		<div class="content">
			<center style="overflow-x:auto; margin-top: 20px;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			           
			            <th>Tài khoản</th>
			            <th>Mật khẩu</th>
			            <th>Họ tên</th>
			            <th>Giới tính</th>
			            <th>Chức vụ</th>
			            <th>Số điện thoại</th>
			        </tr>
			        <tbody>
			        	<?php
		        		
		        		while ($row = pg_fetch_array($result)):

		        		?>
			        	<tr style="text-align: center; height: 30px;">
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
	</div>

</body>
</html>