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
	<title>Doanh thu theo tháng | qlks.bk</title>
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
				$sql = "with bang as(
						select date_part( 'month', ngaytt ) as thang ,sum(tongtientt) as doanhthu from hoadon hd
						where date_part( 'year', ngaytt )=2018 
						group by date_part( 'month',ngaytt )
						)
						select dt.thang, (doanhthu || ' đ') as doanhthu
						from doanhthu dt left join bang on dt.thang = bang.thang";

				$result = pg_query($db, $sql);

				$sql1 = "select (sum(tongtientt) || ' đ') as doanhthu
						from hoadon hd
						where date_part('year', ngaytt) = $nam";

				$result1 = pg_query($db,$sql1);				
		    }

		    	


		?>

		<div class="content">
			<center><h2 class="ten">Doanh thu của năm <?php echo "$nam";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="500" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>Tháng</th>
			            <th>Doanh thu</th>

			        </tr>
			        <tbody>
			        	<?php
			        		
			        		while ($row = pg_fetch_array($result)):
			        			
			        			

			        	?>
			        	<tr style="text-align: center; height: 30px;">

			                
			                <td><?php echo $row['thang']; ?></td>
			                <td><?php echo $row['doanhthu']; ?></td>
			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			    </table>   
		    </center>
		    <?php
		    $row1 = pg_fetch_array($result1);





		    ?>
		    <center><h2 style="font-size: 20px; margin-top: 20px;">Tổng tiền: <?php echo $row1['doanhthu'];?></h2></center>
		</div>
	</div>

</body>
</html>