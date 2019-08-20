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
	<title>Thống kê dịch vụ | qlks.bk</title>
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
			$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
			if(!$db){
			echo "Error : Unable to open database\n";
			}
			if (isset($_POST['hoantat'])) {
				$sql = "select dv.madv, tendv, loaidv, (dongia||' đ') as dongia, sum(soluong) as tongso
						from sudungdv as sddv, dichvu as dv
						where date_part( 'year', ngaysd )=$nam and sddv.madv=dv.madv
						group by dv.madv";
				$result = pg_query($db, $sql);



				$sql1 = "select sddv.madv, tendv, loaidv, (dongia || ' đ') as dongia, count(*) as solan
						from sudungdv sddv, dichvu dv
						where sddv.madv = dv.madv and date_part('year', ngaysd) = $nam
						group by sddv.madv, tendv, loaidv, dongia
						having count(*) >= ALL (select count(*) from sudungdv where date_part('year', ngaysd) = $nam group by madv)";
				$result1 = pg_query($db, $sql1);

				$sql2 = "select madv, tendv, loaidv,(dongia||'đ') as dongia,sum(sddv.soluong) as soluong
						from sudungdv as sddv
						natural join dichvu as dv
						where date_part('year', ngaysd) = $nam
						group by madv , tendv,dongia, loaidv
						having sum(sddv.soluong) >= all (select sum(sddv.soluong)
						from sudungdv as sddv where date_part('year', ngaysd) = $nam group by madv)";

				$result2 = pg_query($db, $sql2);

				$sql3 = "select sddv.madv, tendv, loaidv, (dongia || ' đ') as dongia, count(*) as solan
						from sudungdv sddv, dichvu dv
						where sddv.madv = dv.madv and loaidv = 'Giải trí - Thư giãn' and date_part('year', ngaysd) = $nam
						group by sddv.madv, tendv, loaidv, dongia
						having count(*) >= ALL (select count(*) from sudungdv where loaidv = 'Giải trí - Thư giãn' and date_part('year', ngaysd) = $nam group by madv)
						";

				$result3 = pg_query($db, $sql3);		

					
		    }

		    	


		?>

		<div class="content">
			<center><h2 class="ten">Các dịch vụ được sử dụng trong năm <?php echo "$nam";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã dịch vụ</th>
			            <th>Tên dịch vụ</th>
			            <th>Loại dịch vụ</th>
			            <th>Giá tiền</th>
			            <th>Tổng số</th>

			            
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
			                <td><?php echo $row['madv']; ?></td>
			                <td><?php echo $row['tendv']; ?></td>
			                <td><?php echo $row['loaidv']; ?></td>
			                <td><?php echo $row['dongia']; ?></td>
			                <td><?php echo $row['tongso']; ?></td>

			                

			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center>
			<center><h2 class="ten">Dịch vụ được yêu cầu nhiều nhất <?php echo "$nam";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã dịch vụ</th>
			            <th>Tên dịch vụ</th>
			            <th>Loại dịch vụ</th>
			            <th>Giá tiền</th>
			            <th>Số lần</th>

			            
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
			                <td><?php echo $row['madv']; ?></td>
			                <td><?php echo $row['tendv']; ?></td>
			                <td><?php echo $row['loaidv']; ?></td>
			                <td><?php echo $row['dongia']; ?></td>
			                <td><?php echo $row['solan']; ?></td>

			                

			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center>
		    <center><h2 class="ten">Dịch vụ được tiêu thụ nhiều nhất <?php echo "$nam";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã dịch vụ</th>
			            <th>Tên dịch vụ</th>
			            <th>Loại dịch vụ</th>
			            <th>Giá tiền</th>
			            <th>Số lượng</th>

			            
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
			                <td><?php echo $row['madv']; ?></td>
			                <td><?php echo $row['tendv']; ?></td>
			                <td><?php echo $row['loaidv']; ?></td>
			                <td><?php echo $row['dongia']; ?></td>
			                <td><?php echo $row['soluong']; ?></td>


			                

			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center>  
			<center><h2 class="ten">Dịch vụ giải trí - thư giãn được yêu cầu nhiều nhất <?php echo "$nam";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã dịch vụ</th>
			            <th>Tên dịch vụ</th>
			            <th>Loại dịch vụ</th>
			            <th>Giá tiền</th>
			            <th>Số lần</th>

			            
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
			                <td><?php echo $row['madv']; ?></td>
			                <td><?php echo $row['tendv']; ?></td>
			                <td><?php echo $row['loaidv']; ?></td>
			                <td><?php echo $row['dongia']; ?></td>
			                <td><?php echo $row['solan']; ?></td>


			                

			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center>  
				
		</div>
	</div>
</body>
</html>