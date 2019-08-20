
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
    <title>Chỉnh sửa phòng | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/suaphong.css">  
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
		<div class="themphong-menu">
			<center>
				<h2 class="title">Form sửa phòng</h2>
				<form class="themphong-form" method="POST">
					<div class="line">
						<input type="text" name="maphong" placeholder="Mã phòng">
					</div>
					<div class="line">
						Kiểu phòng: 
						<select name="kieuphong">
						<option>Đơn</option>
						<option>Đôi</option>
						</select>
					</div>
					<div class="line">
						Loại phòng:
						<select name="loaiphong">
						<option>Thường</option>
						<option>Vip</option>
						</select>
					</div>
					<div class="line">
						<input type="text" name="giatien" placeholder="Giá tiền">
					</div>
					<div id="line-btn" class="line btnline">
						<input type="submit" name="hoantat" value="Hoàn tất" class="btn" onclick="return confirm('Bạn đã chắc chắn')">
					</div>
				</form>
			</center>
			<?php
				$maphong = $_POST['maphong'];
				$kieuphong = $_POST['kieuphong'];
				$loaiphong = $_POST['loaiphong'];
				$giatien = $_POST['giatien'];

				$dbconn = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
				if (!$dbconn) {
					echo "Error : Unable to open database\n";
				}

								

				if(isset($_POST['hoantat'])){
					if ($maphong == '' || $kieuphong == '' || $loaiphong == '' || $giatien == '') {
						echo "Vui lòng nhập đầy đủ thông tin";
					}else{

						$sql = "select * from thuephong where map = '$maphong' and thanhtoan = 0";
						$query = pg_query($dbconn, $sql);
						$num_rows = pg_num_rows($query);

						if ($num_rows == 0) {
							$sql1 = "update phong set kieup = '$kieuphong' where map = '$maphong' and trangthai = 1";
							$query1 = pg_query($dbconn, $sql1);

							$sql2 = "update phong set loaip = '$loaiphong' where map = '$maphong' and trangthai = 1";
							$query2 = pg_query($dbconn, $sql2);

							$sql3 = "update phong set gia = $giatien where map = '$maphong' and trangthai = 1";
							$query3 = pg_query($dbconn, $sql3);

							if (!$query3 || !$query2 || !$query1) {
								echo "Vui lòng nhập đúng thông tin !";
							}else{
								$sql4 = "select map, kieup, loaip, (gia || ' đ') as gia from phong where map = '$maphong' and trangthai = 1";
								$result = pg_query($dbconn, $sql4);
							}
							
						}else
							echo "Phòng đang đưọc sử dụng không đưọc chỉnh sửa.";


						
					}
				}
				pg_close($dbconn);
		?>								
		</div>
	
				


		<div class="content">
			<center style="overflow-x:auto; margin-top: 20px;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			           
			            <th>Mã phòng</th>
			            <th>Kiểu phòng</th>
			            <th>Loại phòng</th>
			            <th>Giá tiền</th>
			        </tr>
			        <tbody>
			        	<?php
		        		
		        		while ($row = pg_fetch_array($result)):

		        		?>
			        	<tr style="text-align: center; height: 30px;">
			        		<td><?php echo $row['map']; ?></td>
			                <td><?php echo $row['kieup']; ?></td>
			                <td><?php echo $row['loaip']; ?></td>
			                <td><?php echo $row['gia']; ?></td>
			               
				                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center> 

			
		</div>
	</div>

</body>
</html>