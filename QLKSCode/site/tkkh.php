
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
	<title>Thống kê khách hàng | qlks.bk</title>
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
				<h2 class="title">Form thống kê</h2>
				<form class="bill-form" method="POST">
					<div class="line">
					<input type="text" name="nam" placeholder="Năm: VD: 2018">
					</div>
					<div id="line-btn" class="line btnline">
						<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
				</form>
			</center>
		</div>

		<?php
			$nam = $_POST['nam'];

		?>
		<?php
		


		?>
		<?php
			$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
			if(!$db){
			echo "Error : Unable to open database\n";
			}
			if (isset($_POST['hoantat'])) {
				$sql1 = "with bang as(
						select distinct makh, madv
						from sudungdv where date_part('year', ngaysd) = $nam
						)
						select kh.*, count(*) as soluong
						from bang, khachhang kh
						where kh.makh = bang.makh
						group by kh.makh
						having count(*) >= ALL(select count(*) from bang group by makh)";

				$result1 = pg_query($db, $sql1);

				$sql2 = "select distinct kh.*,ngayden, ngaydi, (ngaydi - ngayden + 1) as songay
						from khachhang kh, thuephong tp
						where kh.makh = tp.makh and date_part('year', ngaydi) = $nam
						and (ngaydi - ngayden + 1) = (select max(ngaydi - ngayden + 1) from khachhang, thuephong where khachhang.makh = thuephong.makh and date_part('year', ngaydi) = $nam)
						";		

				$result2 = pg_query($db, $sql2);

				$sql3 = "select kh.*, (sum(tongtientt) || ' đ') as tongtien
						from khachhang kh, hoadon hd
						where kh.makh = hd.makh and date_part('year', ngaytt) = $nam
						group by kh.makh
						having sum(tongtientt) >= all(select sum(tongtientt) from hoadon where date_part('year', ngaytt) = $nam group by makh)";

				$result3 = pg_query($db, $sql3);

				$sql4 = "with bang as(
						select distinct kh.makh, gioitinh
						from khachhang kh,thuephong tp
						where kh.makh = tp.makh and date_part('year', ngayden) = $nam
						)
						select gioitinh, count(*) as soluong
						from bang
						group by gioitinh
						";

				$result4 = pg_query($db, $sql4);


				$sql5 = "with bang as(
						select distinct makh, date_part('month', ngayden) as thangden
						from thuephong
						where date_part('year', ngayden) = $nam	
						)
						select thangden, count(*) as soluongkhach
						from bang
						group by thangden
						having count(*) >= ALL(select count(*) from bang group by thangden)";

				$result5 = pg_query($db, $sql5);								

					
		    }

		    	


		?>

		<div class="content">
			<center><h2 class="ten">Khách hàng sử dụng nhiều dịch vụ nhất <?php echo "$nam";?></h2></center>
		<center style="overflow-x:auto;">
			<table  width="1200" border="1" style="border-collapse: collapse;">
		        <tr style="height: 50px;">
		            <th>STT</th>
		            <th>Mã khách hàng</th>
		            <th>Họ tên khách hàng</th>
		            <th>Địa chỉ</th>
		            <th>Số CMND</th>
		            <th>Số điện thoại</th>
		            <th>Giới tính</th>
		            <th>Quốc tịch</th>
		            <th>Số lượng dịch vụ</th>
		        </tr>
		        <tbody>
		        	<?php
		        		$b = 0;
		        		while ($row = pg_fetch_array($result1)):
		        			$b = $b + 1;
		        			# code...

		        	?>
		        	<tr style="text-align: center; height: 30px;">

		                <td><?php echo "".$b."" ?></td>
		                <td><?php echo $row['makh']; ?></td>
		                <td><?php echo $row['hoten']; ?></td>
		                <td><?php echo $row['diachi']; ?></td>
		                <td><?php echo $row['cmnd']; ?></td>
		                <td><?php echo $row['tel']; ?></td>
		                <td><?php echo $row['gioitinh']; ?></td>
		                <td><?php echo $row['quoctich']; ?></td>
		                <td><?php echo $row['soluong']; ?></td>

		                
		              

		            </tr>
        			<?php endwhile; ?>

		        </tbody>
		        
		    </table>   
	    </center> 
		<center><h2 class="ten">Khách hàng lưu trú liên tục lâu nhất <?php echo "$nam";?></h2></center>
		<center style="overflow-x:auto;">
			<table  width="1200" border="1" style="border-collapse: collapse;">
		        <tr style="height: 50px;">
		            <th>STT</th>
		            <th>Mã khách hàng</th>
		            <th>Họ tên khách hàng</th>
		            <th>Địa chỉ</th>
		            <th>Số CMND</th>
		            <th>Số điện thoại</th>
		            <th>Giới tính</th>
		            <th>Quốc tịch</th>
		            <th>Ngày đến</th>
		            <th>Ngày đi</th>
		            <th>Số ngày</th>
		        </tr>
		        <tbody>
		        	<?php
		        		$b = 0;
		        		while ($row = pg_fetch_array($result2)):
		        			$b = $b + 1;
		        			# code...

		        	?>
		        	<tr style="text-align: center; height: 30px;">

		                <td><?php echo "".$b."" ?></td>
		                <td><?php echo $row['makh']; ?></td>
		                <td><?php echo $row['hoten']; ?></td>
		                <td><?php echo $row['diachi']; ?></td>
		                <td><?php echo $row['cmnd']; ?></td>
		                <td><?php echo $row['tel']; ?></td>
		                <td><?php echo $row['gioitinh']; ?></td>
		                <td><?php echo $row['quoctich']; ?></td>
		                <td><?php echo $row['ngayden']; ?></td>
		                <td><?php echo $row['ngaydi']; ?></td>
		                <td><?php echo $row['songay']; ?></td>

		                
		              

		            </tr>
        			<?php endwhile; ?>

		        </tbody>
		        
		    </table>   
	    </center> 

		<center><h2 class="ten">Khách hàng có tổng tiền hóa đơn lớn nhất <?php echo "$nam";?></h2></center>
		<center style="overflow-x:auto;">
			<table  width="1200" border="1" style="border-collapse: collapse;">
		        <tr style="height: 50px;">
		            <th>STT</th>
		            <th>Mã khách hàng</th>
		            <th>Họ tên khách hàng</th>
		            <th>Địa chỉ</th>
		            <th>Số CMND</th>
		            <th>Số điện thoại</th>
		            <th>Giới tính</th>
		            <th>Quốc tịch</th>
		            <th>Tổng tiền</th>
		        </tr>
		        <tbody>
		        	<?php
		        		$b = 0;
		        		while ($row = pg_fetch_array($result3)):
		        			$b = $b + 1;
		        			# code...

		        	?>
		        	<tr style="text-align: center; height: 30px;">

		                <td><?php echo "".$b."" ?></td>
		                <td><?php echo $row['makh']; ?></td>
		                <td><?php echo $row['hoten']; ?></td>
		                <td><?php echo $row['diachi']; ?></td>
		                <td><?php echo $row['cmnd']; ?></td>
		                <td><?php echo $row['tel']; ?></td>
		                <td><?php echo $row['gioitinh']; ?></td>
		                <td><?php echo $row['quoctich']; ?></td>
		                <td><?php echo $row['tongtien']; ?></td>
		                
		              

		            </tr>
        			<?php endwhile; ?>

		        </tbody>
		        
		    </table>   
	    </center> 


		<center><h2 class="ten">Số lượng khách hàng nam nữ <?php echo "$nam";?></h2></center>
		<center style="overflow-x:auto;">
			<table  width="1200" border="1" style="border-collapse: collapse;">
		        <tr style="height: 50px;">
		            <th>Giới tính</th>
		            <th>Số lượng</th>
		        </tr>
		        <tbody>
		        	<?php
		        		
		        		while ($row = pg_fetch_array($result4)):
		        			

		        	?>
		        	<tr style="text-align: center; height: 30px;">

		                
		                <td><?php echo $row['gioitinh']; ?></td>
		                <td><?php echo $row['soluong']; ?></td>
		                
		              

		            </tr>
        			<?php endwhile; ?>

		        </tbody>
		        
		    </table>   
	    </center>
	    <center><h2 class="ten">Tháng có nhiều khách đến nhất <?php echo "$nam";?></h2></center>
		<center style="overflow-x:auto;">
			<table  width="1200" border="1" style="border-collapse: collapse;">
		        <tr style="height: 50px;">
		            <th>Tháng</th>
		            <th>Số lượng</th>
		        </tr>
		        <tbody>
		        	<?php
		        		
		        		while ($row = pg_fetch_array($result5)):
		        			

		        	?>
		        	<tr style="text-align: center; height: 30px;">

		                
		                <td><?php echo $row['thangden']; ?></td>
		                <td><?php echo $row['soluongkhach']; ?></td>
		                
		              

		            </tr>
        			<?php endwhile; ?>

		        </tbody>
		        
		    </table>   
	    </center>
		</div>
	</div>

</body>
</html>