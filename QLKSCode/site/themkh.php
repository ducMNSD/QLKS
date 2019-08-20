
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
    <title>Thêm khách hàng | qlks.bk</title>
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
				<h2 class="title">Form thêm khách hàng</h2>
				<form class="themkh-form" method="POST">
					<div class="line">
						<input type="text" name="hoten" placeholder="Họ và tên">
					</div>
					<div class="line">
						<input type="text" name="diachi" placeholder="Địa chỉ">
					</div>
					<div class="line">
						<input type="text" name="cmnd" placeholder="Số CMND">
					</div>
					<div class="line">
						<input type="text" name="sdt" placeholder="Số điện thoại">
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
						<input type="text" name="quoctich" placeholder="Quốc tịch">
					</div>

					<div id="line-btn" class="line btnline">
						<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
					</div>
				</form>
			</center>								
		</div>
	<?php
		$hoten = $_POST['hoten'];
		$diachi = $_POST['diachi'];
		$cmnd = $_POST['cmnd'];
		$sdt = $_POST['sdt'];
		$gioitinh = $_POST['gioitinh'];
		$quoctich = $_POST['quoctich'];


		$dbconn = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
		if (!$dbconn) {
			echo "Error : Unable to open database\n";
		}

						

		if(isset($_POST['hoantat'])){
			if ($hoten == '' || $diachi == '' || $cmnd == '' || $sdt == '' || $gioitinh == '' || $quoctich == '') {
				echo "Vui lòng nhập đầy đủ thông tin";
			}else{
				$sql = "insert into khachhang(hoten, diachi, cmnd, tel, gioitinh, quoctich) values ('$hoten', '$diachi', '$cmnd', '$sdt', '$gioitinh', '$quoctich');";
				$query = pg_query($dbconn, $sql);
				if (!$query) {
					echo "Vui lòng nhập đúng thông tin !";
				}else{
					$sql1 = "select * from khachhang where khachhang.cmnd = '$cmnd'";
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
			           
			            <th>Mã khách hàng</th>
			            <th>Họ tên khách hàng</th>
			            <th>Địa chỉ</th>
			            <th>Số CMND</th>
			            <th>Số điện thoại</th>
			            <th>Giới tính</th>
			            <th>Quốc tịch</th>
			        </tr>
			        <tbody>
			        	<?php
		        		
		        		while ($row = pg_fetch_array($result)):

		        		?>
			        	<tr style="text-align: center; height: 30px;">
			        		<td><?php echo $row['makh']; ?></td>
			                <td><?php echo $row['hoten']; ?></td>
			                <td><?php echo $row['diachi']; ?></td>
			                <td><?php echo $row['cmnd']; ?></td>
			                <td><?php echo $row['tel']; ?></td>
			                <td><?php echo $row['gioitinh']; ?></td>
			                <td><?php echo $row['quoctich']; ?></td>
				                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center> 

			
		</div>
	</div>

</body>
</html>