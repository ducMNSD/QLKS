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
    <link rel="stylesheet" type="text/css" href="../CSS/service.css">
	<link rel="icon" href="/Image/favicon.ico">
<body>
	<div id="menu">
		<ul>
			<li><a href="../PHP/trangchu.php">Trang chủ</a></li>
			<li>
			<a href="">Dịch vụ</a>
			<ul class="sub-menu">
				<li><a href="../site/timdv.php">Tìm kiếm dịch vụ</a></li>
				<li><a href="../site/sudungdv.php">Sử dụng dịch vụ</a></li>
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

			
			$sql = "select kh.makh, hoten, madv, ngaysd, soluong
				from khachhang kh, sudungdv sddv
				where kh.makh = sddv.makh and thanhtoan = 0";

			$result = pg_query($db, $sql);	

			
							



		?>
		<div>
			<center><h2 class="ten">Danh sách Dịch vụ chưa thanh toán</h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border=1 style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã khách hàng</th>
			            <th>Họ tên</th>
			            <th>Mã dịch vụ</th>

			            <th>Ngày sử dụng</th>
			            <th>Số lượng</th>
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
			                <td><?php echo $row['madv']; ?></td>
			                <td><?php echo $row['ngaysd']; ?></td>
			                <td><?php echo $row['soluong']; ?></td>

			                
			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center> 

		</div>
	</div>



</body>
</html>