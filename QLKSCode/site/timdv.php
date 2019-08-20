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
			<a href="../site/dichvu.php">Dịch vụ</a>
			<ul class="sub-menu">
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
		<div class="login-box">
			<form class="login-form" method="POST">
				<div>Mã Dịch vụ: <input type="text" name="madv" placeholder="VD: D101"></div>
				<div>Tên dịch vụ: <input type="text" name="tendv" placeholder="VD: Coca"></div>
				<div>Loại dịch vụ: 
					<select name="loaidv">
					<option>Tất cả</option>>
					<option>Đồ uống</option>
					<option>Đồ ăn</option>
					<option>Giải trí - Thư giãn</option>
					</select>
				</div>
				<input type="submit" name="duyet" value="Duyệt">
			</form>
		</div>
		<?php 
			$madv = $_POST['madv'];
			$tendv = $_POST['tendv'];
			$loaidv = $_POST['loaidv'];


		?>
		<?php
			$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
			if(!$db){
				echo "Error : Unable to open database\n";
			}

			if($madv == '')
				$sql1 = "select * from dichvu where trangthai = 1";
			else
				$sql1 = "select * from dichvu where madv = '$madv' and trangthai = 1";

			if($tendv == '')
				$sql2 = "select * from dichvu where trangthai = 1";
			else
				$sql2 = "select * from dichvu where tendv = '$tendv' and trangthai = 1";
			if($loaidv == 'Tất cả')
				$sql3 = "select * from dichvu where trangthai = 1";
			else
				$sql3 = "select * from dichvu where loaidv = '$loaidv' and trangthai = 1";
			if (isset($_POST['duyet'])) {
				$sql = "(select * from dichvu where trangthai = 1) INTERSECT ($sql1) INTERSECT ($sql2) INTERSECT ($sql3) order by madv asc";
				$result = pg_query($db, $sql);
		    	if(!$result)
		    		echo "Error: Không có dịch vụ nào\n";
				# code...
			}else{
				$sql = "select * from dichvu where trangthai = 1 order by madv asc";
				$result = pg_query($db, $sql);
		    	if(!$result)
		    		echo "Error: Không có dịch vụ nào\n";
			}

			
							



		?>
		<div>
			<center><h2 class="ten">Danh sách Dịch vụ</h2></center>
			<center style="overflow-x:auto;">
				<table  width="1200" border=1 style="border-collapse: collapse;">
			        <tr style="height: 50px;">
			            <th>STT</th>
			            <th>Mã Dịch vụ</th>
			            <th>Tên dịch vụ</th>
			            <th>Loại dịch vụ</th>
			            <th>Đơn giá</th>
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
			                <td><?php echo $row['dongia']; echo " đ"; ?></td>
			                
			              

			            </tr>
	        			<?php endwhile; ?>

			        </tbody>
			        
			    </table>   
		    </center> 

		</div>
	</div>



</body>
</html>