
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
    <title>Thêm dịch vụ | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/themdv.css">  
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
		<div class="themdv-menu">
			<center>
				<h2 class="title">Form thêm dịch vụ</h2>
				<form class="themdv-form" method="POST">
					<div class="line">
						<input type="text" name="madv" placeholder="Mã dịch vụ">
					</div>
					<div class="line">
						<input type="text" name="tendv" placeholder="Tên dịch vụ">
					</div>
					<div class="line">
						Loại dịch vụ: 
						<select name="loaidv">
						<option>Đồ uống</option>>
						<option>Đồ ăn</option>
						<option>Giải trí - Thư giãn</option>
						<option>Khác</option>
						</select>
					</div>
					<div class="line">
						<input type="text" name="giatien" placeholder="Giá tiền">
					</div>
					<div id="line-btn" class="line btnline">
						<input type="submit" name="hoantat" value="Hoàn tất" class="btn">
					</div>
				</form>
			</center>
			<?php
				$madv = $_POST['madv'];
				$tendv = $_POST['tendv'];
				$loaidv = $_POST['loaidv'];
				$giatien = $_POST['giatien'];

				$dbconn = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
				if (!$dbconn) {
					echo "Error : Unable to open database\n";
				}

								

				if(isset($_POST['hoantat'])){
					if ($madv == '' || $tendv == '' || $loaidv == '' || $giatien == '') {
						echo "Vui lòng nhập đầy đủ thông tin";
					}else{
						$sql2 = "select * from dichvu where madv = '$madv' and trangthai = 0";
						$query2 = pg_query($dbconn, $sql2);
						$number = pg_num_rows($query2);

						if ($number == 0) {
							$sql = "insert into dichvu values ('$madv', '$tendv', '$loaidv', $giatien);";
							$query = pg_query($dbconn, $sql);
						}else{
							$sql = "update dichvu set tendv = '$tendv', loaidv = '$loaidv', dongia = $giatien, trangthai = 1 where madv = '$madv'";
							$query = pg_query($dbconn, $sql);
						}



						
						if (!$query) {
							echo "Vui lòng nhập đúng thông tin !";
						}else{
							$sql1 = "select madv, tendv, loaidv, (dongia || ' đ') as gia from dichvu where madv = '$madv' and trangthai = 1";
							$result = pg_query($dbconn, $sql1);
						}
					}
				}
				pg_free_result($query);
				pg_close($dbconn);
			?>								
		</div>
	
				


		<div class="content">
			<center style="overflow-x:auto; margin-top: 20px;">
				<table  width="1200" border="1" style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			           
			            <th>Mã dịch vụ</th>
			            <th>Tên dịch vụ</th>
			            <th>Loại dịch vụ</th>
			            <th>Giá tiền</th>
			        </tr>
			        <tbody>
			        	<?php
		        		
		        		while ($row = pg_fetch_array($result)):

		        		?>
			        	<tr style="text-align: center; height: 30px;">
			        		<td><?php echo $row['madv']; ?></td>
			                <td><?php echo $row['tendv']; ?></td>
			                <td><?php echo $row['loaidv']; ?></td>
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