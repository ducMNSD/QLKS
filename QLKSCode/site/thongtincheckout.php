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
	<title>Thông tin check out | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/thongtincheckout.css">
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
		<div class="bill-menu">
			<center>
				<h2 class="title">Nhập mã khách hàng</h2>
				<form class="bill-form" method="POST">
					<div class="line">
					<input type="text" name="makh" placeholder="Mã khách hàng">
					</div>
					<div id="line-btn" class="line btnline">
						<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
				</form>
			</center>
		</div>

		<?php
			$makh = $_POST['makh'];

		?>
		<?php
			$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
			if(!$db){
			echo "Error : Unable to open database\n";
			}
			if (isset($_POST['hoantat'])) {
				$sql1 = "select * from khachhang where makh = $makh";
				$result_ttkh = pg_query($db, $sql1);
				
				$sql2 = "select kh.hoten, sddv.*
						from khachhang kh, sudungdv sddv
						where kh.makh = sddv.makh and sddv.makh = $makh and thanhtoan = 1";
				$result_sddv = pg_query($db, $sql2);
				$sql3 = "select kh.hoten, tp.makh, map, ngayden, ngaydi, (tiencoc || ' đ') as tiencoc, (tongtien || ' đ') as tongtien
						 from khachhang kh, thuephong tp
						 where kh.makh = tp.makh
						 and tp.makh = $makh and thanhtoan = 1";
				$result_thuephong = pg_query($db, $sql3);

				$sql4 = "select mahd, kh.hoten, hd.makh, ngaytt, hinhthuctt,(tienp || ' đ') as tienp, (tiendv || ' đ') as tiendv,
				 		(tienthue || ' đ') as tienthue,(tiencoc || ' đ') as tiencoc, (tongtientt || ' đ') as tongtientt
						from khachhang kh, hoadon hd
						where kh.makh = hd.makh and hd.makh = $makh order by mahd asc";
				$result_hoadon = pg_query($db, $sql4); 

		    }

		    	


		?>

		<div class="content">
			<center><h2 class="ten">Thông tin khách hàng</h2></center>
			<center style="overflow-x:auto;">
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
			        		while ($row = pg_fetch_array($result_ttkh)):
			        			
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

			<center><h2 class="ten">Lịch sử sử dụng dịch vụ</h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Họ tên</th>
			            <th>Mã khách hàng</th>
			            <th>Mã dịch vụ</th>
			            <th>Ngày sử dụng</th>
			            <th>Số lượng</th>
			            <th>Tổng tiền</th>

			        </tr>
			        <tbody>
			        	<?php
			        		$b = 0;
			        		while ($row = pg_fetch_array($result_sddv)):
			        			$b = $b + 1;
			        			# code...

			        	?>
			        	<tr style="text-align: center; height: 30px;">

			                <td><?php echo "".$b."" ?></td>
			                <td><?php echo $row['hoten']; ?></td>
			                <td><?php echo $row['makh']; ?></td>
			                <td><?php echo $row['madv']; ?></td>
			                <td><?php echo $row['ngaysd']; ?></td>
			                <td><?php echo $row['soluong']; ?></td>
			                <td><?php echo $row['tongtien']; echo " đ"; ?></td>
			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			    </table>   
		    </center>
			<center><h2 class="ten">Lịch sử thuê phòng</h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Họ tên</th>
			            <th>Mã khách hàng</th>
			            <th>Mã phòng</th>
			            <th>Ngày đến</th>
			            <th>Ngày đi</th>
			            <th>Tiền cọc</th>
			            <th>Tổng tiền</th>
			        </tr>
			        <tbody>
			        	<?php
			        		$b = 0;
			        		while ($row = pg_fetch_array($result_thuephong)):
			        			$b = $b + 1;

			        	?>
			        	<tr style="text-align: center; height: 30px;">

			                <td><?php echo "".$b."" ?></td>
			                <td><?php echo $row['hoten']; ?></td>
			                <td><?php echo $row['makh']; ?></td>  
			                <td><?php echo $row['map']; ?></td>
			                <td><?php echo $row['ngayden']; ?></td>
			                <td><?php echo $row['ngaydi']; ?></td>
			                <td><?php echo $row['tiencoc']; ?></td>
			                <td><?php echo $row['tongtien']; ?></td>

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			    </table>   
		    </center>

			<center><h2 class="ten">Lịch sử hóa đơn</h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>Mã hóa đơn</th>
			            <th>Họ tên</th>
			            <th>Mã khách hàng</th>
			            <th>Ngày thanh toán</th>
			            <th>Hình thức thanh toán</th>
			            <th>Tiền phòng</th>
			            <th>Tiền dịch vụ</th>
			            <th>Tiền thuế (5%)</th>
			            <th>Tiền cọc</th>
			            <th>Tổng tiền thanh toán</th>
			        </tr>
			        <tbody>
			        	<?php
			        		while ($row = pg_fetch_array($result_hoadon)):
			        	?>
			        	<tr style="text-align: center; height: 30px;">
			                <td><?php echo $row['mahd']; ?></td>
			                <td><?php echo $row['hoten']; ?></td>  
			                <td><?php echo $row['makh']; ?></td>
			                <td><?php echo $row['ngaytt']; ?></td>
			                <td><?php echo $row['hinhthuctt']; ?></td>
			                <td><?php echo $row['tienp']; ?></td>
			                <td><?php echo $row['tiendv']; ?></td>
			                <td><?php echo $row['tienthue']; ?></td>
			                <td><?php echo $row['tiencoc']; ?></td>
			                <td><?php echo $row['tongtientt']; ?></td>

			            </tr>
	        			<?php endwhile; ?>


			        </tbody>
			    </table>
			</center>
		</div>
	</div>

</body>
</html>