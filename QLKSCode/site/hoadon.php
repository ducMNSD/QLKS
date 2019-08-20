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
	<title>Hóa đơn | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/Hoadon.css">
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
				<h2 class="title">Form hóa đơn</h2>
				<form class="bill-form" method="POST">
					<div class="line">
					<input type="text" name="makh" placeholder="Mã khách hàng">
					</div>
					<div class="line">
						<input type="text" name="ngaythanhtoan" placeholder="Ngày thanh toán">
					</div>
					<div class="line-radio">
						 <tr>
					        <td> Hình thức thanh toán : </td></br>
					         <td><input type="radio" name="hinhthuctt" value="Tiền mặt" checked> Tiền mặt</br>       
					          <input type="radio" name="hinhthuctt" value="Thẻ"> Thẻ
					          </td>
					    </tr>
				    </div>
					<div id="line-btn" class="line btnline">
						<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
				</form>
			</center>
		</div>

		<?php
			$makh = $_POST['makh'];
			$ngaytt = $_POST['ngaythanhtoan'];
			$hinhthuctt = $_POST['hinhthuctt'];

		?>
		<?php
			$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
			if(!$db){
			echo "Error : Unable to open database\n";
			}
			if (isset($_POST['hoantat'])) {
				$sql_update = "select update_ngaydi($makh,'$ngaytt')";
				$result_update = pg_query($db, $sql_update);

				$sql = "select kh.hoten, sddv.*
						from khachhang kh, sudungdv sddv
						where kh.makh = sddv.makh and sddv.makh = $makh and thanhtoan = 0";
				$result = pg_query($db, $sql);
				$sql1 = "select kh.hoten, tp.makh, map, ngayden, ngaydi, (tiencoc || ' đ') as tiencoc, (tongtien || ' đ') as tongtien
						 from khachhang kh, thuephong tp
						 where kh.makh = tp.makh
						 and tp.makh = $makh and thanhtoan = 0";
				$result1 = pg_query($db, $sql1);
				$sql_insert = "insert into hoadon(makh, ngaytt, hinhthuctt) values ($makh, '$ngaytt', '$hinhthuctt')";
				$result_insert = pg_query($db, $sql_insert);	


				$sql2 = "select mahd, kh.hoten, hd.makh, ngaytt, hinhthuctt,(tienp || ' đ') as tienp, (tiendv || ' đ') as tiendv,
				 		(tienthue || ' đ') as tienthue,(tiencoc || ' đ') as tiencoc, (tongtientt || ' đ') as tongtientt
						from khachhang kh, hoadon hd
						where kh.makh = hd.makh and hd.makh = $makh and ngaytt = '$ngaytt' order by mahd desc limit 1";
				$result_hoadon = pg_query($db, $sql2); 

		    }

		    	


		?>

		<div class="content">
			<center><h2 class="ten">Dịch vụ chưa thanh toán</h2></center>
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
			        		while ($row = pg_fetch_array($result)):
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
			<center><h2 class="ten">Phòng chưa thanh toán</h2></center>
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
			        		while ($row = pg_fetch_array($result1)):
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

			<center><h2 class="ten">Hóa đơn</h2></center>
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