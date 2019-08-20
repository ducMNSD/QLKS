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
	<title>Thống kê phòng | qlks.bk</title>
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
				$sql1 = "select p.map , kieup, loaip, (gia||' đ') as gia, count(*) as solan
						from thuephong tp, phong p
						where p.map = tp.map and date_part('year', ngayden) = $nam
						group by p.map
						having count(*) >= all ( select count(*) from thuephong where date_part('year', ngayden) = $nam group by map)";

				$result1 = pg_query($db, $sql1);

				$sql2 = "select kieup, loaip, (gia || ' đ') as gia, count(*) solan
							from thuephong tp, phong p
							where tp.map = p.map and date_part('year', ngayden) = $nam
							group by kieup, loaip, gia
							having count (*) >= all (select count(*) from thuephong natural join phong where date_part('year', ngayden) = $nam group by kieup, loaip, gia)
							";

				$result2 = pg_query($db, $sql2);

				$sql3 = "select p.map, kieup, loaip, gia, count(*) as solan
						from phong p, doiphong dp
						where p.map = dp.mpcu and date_part('year', ngaydoi) = $nam
						group by map";
				$result3 = pg_query($db, $sql3);			
					
		    }

		    	


		?>

		<div class="content">
			<center><h2 class="ten">Phòng được thuê nhiều nhất <?php echo "$nam";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã phòng</th>
			            <th>Kiểu phòng</th>
			            <th>Loại phòng</th>
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
			                <td><?php echo $row['map']; ?></td>
			                <td><?php echo $row['kieup']; ?></td>
			                <td><?php echo $row['loaip']; ?></td>
			                <td><?php echo $row['gia']; ?></td>
			                <td><?php echo $row['solan']; ?></td>

			                

			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center>
		    <center><h2 class="ten">Loại và kiểu phòng được thuê nhiều nhất <?php echo "$nam";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Kiểu phòng</th>
			            <th>Loại phòng</th>
			            <th>Giá tiền</th>
			            <th>Số lần</th>

			            
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
			                <td><?php echo $row['kieup']; ?></td>
			                <td><?php echo $row['loaip']; ?></td>
			                <td><?php echo $row['gia']; ?></td>
			                <td><?php echo $row['solan']; ?></td>

			                

			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center>
		    </center>
		    <center><h2 class="ten">Phòng bị đổi nhiều nhất <?php echo "$nam";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>Mã phòng</th>
			            <th>Kiểu phòng</th>
			            <th>Loại phòng</th>
			            <th>Giá tiền</th>
			            <th>Số lần</th>

			            
			        </tr>
			        <tbody>
			        	<?php
			        		
			        		while ($row = pg_fetch_array($result3)):
			        			
			        			# code...

			        	?>
			        	<tr style="text-align: center; height: 30px;">

			                <td><?php echo $row['map']; ?></td>
			                <td><?php echo $row['kieup']; ?></td>
			                <td><?php echo $row['loaip']; ?></td>
			                <td><?php echo $row['gia']; ?></td>
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