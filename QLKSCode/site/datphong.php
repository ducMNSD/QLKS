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
	<title>Đặt phòng | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/datphong.css">
	<link rel="icon" href="/Image/favicon.ico">
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="../PHP/trangchu.php">Trang chủ</a></li>
			<li>
				<a href="../site/phong.php">Phòng</a>
				<!-- <ul class="sub-menu">
				<li><a href="../site/timkiemphong.php">Tìm kiếm</a></li>
				<li><a href="../site/datphong.php">Đặt phòng</a></li>
				<li><a href="../site/doiphong.php">Đổi Phòng</a></li>
			</ul> -->
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
		<div class="login-box">
			<form class="login-form" method="POST">
				<div>Ngày đến: <input type="text" name="ngayden" placeholder="VD: 2018-12-01"></div>
				<div>Ngày đi: <input type="text" name="ngaydi" placeholder="VD: 2018-12-10"></div>
				<div>Kiểu phòng: 
					<select name="kieuphong">
					<option>Tất cả</option>>
					<option>Đơn</option>
					<option>Đôi</option>
					</select>
				</div>
				<div>Loại phòng: 
					<select name="loaiphong">
					<option>Tất cả</option>>
					<option>Thường</option>
					<option>Vip</option>
				</select>

				</div>
				<input type="submit" name="duyet" value="Duyệt">
			</form>
		</div>
		<?php

			$ngayden = $_POST['ngayden'];
			$ngaydi = $_POST['ngaydi'];
			$kieuphong = $_POST['kieuphong'];
			$loaiphong = $_POST['loaiphong'];

		?>

		<?php
		$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
		if(!$db){
			echo "Error : Unable to open database\n";
		}

		if($kieuphong == 'Tất cả')
				$sql2 = "select * from phong where trangthai = 1";
			else
				$sql2 = "select * from phong where kieup = '$kieuphong' and trangthai = 1";

			if ($loaiphong == 'Tất cả')
				$sql3 = "select * from phong where trangthai = 1";
			else
				$sql3 = "select * from phong where loaip = '$loaiphong' and trangthai = 1";
		if (isset($_POST['duyet'])) {
			if ($ngaydi == '') {
				$sql = "(select * from phong where trangthai = 1
						EXCEPT
						(select distinct ph.*
						from phong ph, thuephong tp 
						where ph.map = tp.map and trangthai = 1
						and ((tp.ngayden <= '$ngayden' and tp.ngaydi >= '$ngayden') or tp.ngayden >= '$ngayden')))
						INTERSECT ($sql2) INTERSECT ($sql3)
						order by map asc
						";
				$result = pg_query($db, $sql);
		    	if(!$result)
		    		echo "Error: Không có phòng nào\n";		
			}else{
				$sql = "(select phong.* from phong where trangthai = 1 and '$ngayden' <= '$ngaydi' 
					EXCEPT
					(select distinct phong.*
					from phong, thuephong
					where phong.map = thuephong.map and trangthai = 1
					and ((thuephong.ngayden >= '$ngayden' and thuephong.ngayden <= '$ngaydi') or (thuephong.ngaydi >= '$ngayden' and thuephong.ngaydi <= '$ngaydi'))))
					INTERSECT ($sql2) INTERSECT ($sql3)
					order by map asc
					";
				$result = pg_query($db, $sql);
		    	if(!$result)
		    		echo "Error: Không có phòng nào\n";
	    	}
			
		}						   
		
		?>
		<div>
			<center><h2 class="ten">Danh sách phòng còn trống từ ngày <?php echo "$ngayden";?> đến ngày <?php echo "$ngaydi";?></h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã phòng</th>
			            <th>Kiểu phòng</th>
			            <th>Loại phòng</th>
			            <th>Đơn giá</th>
			            <th>Đặt phòng</th>
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
			                <td><?php echo $row['map']; ?></td>
			                <td><?php echo $row['kieup']; ?></td>
			                <td><?php echo $row['loaip']; ?></td>
			                <td><?php echo $row['gia']; echo " đ"; ?></td>
			                <td><a href="../site/formdatphong.php?ID=<?php echo $row['map']; ?>" style="text-decoration: none; color: #317fbd;">Đặt</a></td>
			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center> 

		</div>
	</div>

</body>
</html>