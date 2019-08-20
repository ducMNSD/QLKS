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
	<title>Tìm kiếm khách hàng | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/timkiemkh.css">
	<link rel="icon" href="/Image/favicon.ico">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="../PHP/trangchu.php">Trang chủ</a></li>
			<li>
				<a href="../site/khachhang.php">Khách hàng</a>
				<ul class="sub-menu">
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
		<center>
		<div class="login-box">
			<form class="login-form" method="POST">
				<div>Mã khách hàng: <input type="text" name="makh" placeholder="VD: 1"></div>
				<div>Họ tên: <input type="text" name="hoten" placeholder="VD: Nguyễn Đình Sơn"></div>
				<div>Địa chỉ: <input type="text" name="diachi" placeholder="VD: Hà Nội"></div>
				<div>Số CMND: <input type="text" name="cmnd" placeholder="VD: 001098011182"></div>
				<div>Số ĐT: <input type="text" name="sdt" placeholder="VD: 0943643789"></div>
				<div>Giới tính: 
					<select name="gioitinh">
						<option>Tất cả</option>
						<option>Nam</option>
						<option>Nữ</option>

					</select>
				</div>
				<div>Quốc tịch: <input type="text" name="quoctich" placeholder="VD: Việt Nam"></div>
				
				<input type="submit" name="duyet" value="Duyệt">
			</form>
		</div>
		<?php
			$makh = $_POST['makh'];
			$hoten = $_POST['hoten'];
			$diachi = $_POST['diachi'];
			$cmnd = $_POST['cmnd'];
			$sdt = $_POST['sdt'];
			$gioitinh = $_POST['gioitinh'];
			$quoctich = $_POST['quoctich'];

		?>
		<?php
			$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
			if(!$db){
			echo "Error : Unable to open database\n";
			}

			if ($makh == '')
				$sql1 = "select * from khachhang";
			else
				$sql1 = "select * from khachhang where makh = $makh";
			if ($hoten == '')
				$sql2 = "select * from khachhang";
			else
				$sql2 = "select * from khachhang where hoten = '$hoten'";
			if ($diachi == '')
				$sql3 = "select * from khachhang";
			else
				$sql3 = "select * from khachhang where diachi = '$diachi'";

			if ($cmnd == '')
				$sql4 = "select * from khachhang";
			else
				$sql4 = "select * from khachhnag where diachi = '$diachi'";
			if ($sdt == '')
				$sql5 = "select * from khachhang";
			else
				$sql5 = "select * from khachhnag where sdt = '$sdt'";
			if ($gioitinh == 'Tất cả')
				$sql7 = "select * from khachhang";
			else
				$sql7 = "select * from khachhang where gioitinh = '$gioitinh'";
			if ($quoctich == '')
				$sql6 = "select * from khachhang";
			else
				$sql6 = "select * from khachhang where quoctich = '$quoctich'";

			if (isset($_POST['duyet'])) {
				$sql = "(select * from khachhang) INTERSECT ($sql1) INTERSECT ($sql2) INTERSECT ($sql3) INTERSECT ($sql4) INTERSECT ($sql5) INTERSECT ($sql6) 
				INTERSECT ($sql7) order by makh asc";
				$result = pg_query($db, $sql);
		    	if(!$result)
		    		echo "Error: Không có khách hàng nào\n";
			}else{
				$sql = "select * from khachhang order by makh asc";
				$result = pg_query($db, $sql);
		    	if(!$result)
		    		echo "Error: Không có khách hàng nào\n";
			}

		?>
		<div>
			<center><h2 class="ten">Danh sách khách hàng</h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" >
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