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
	<title>Khách hàng | qlks.bk</title>
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/customer.css">
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
	<?php
		$db = pg_connect("host=localhost dbname=QLKS user=postgres password=postgres");
		if(!$db){
			echo "Error : Unable to open database\n";
		}
								   
		$sql = "select khachhang.*, min(ngayden) as ngayden 
				from khachhang, thuephong where khachhang.makh = thuephong.makh and thuephong.thanhtoan = 0
				group by khachhang.makh
				order by makh asc
				";
		$result = pg_query($db, $sql);
	    	if(!$result)
	    		echo "Error: Truy van that bai\n";
	?>
	<div>
		<center><h2 class="ten">Danh sách khách hàng chưa thanh toán</h2></center>
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
		                <td><?php echo $row['makh']; ?></td>
		                <td><?php echo $row['hoten']; ?></td>
		                <td><?php echo $row['diachi']; ?></td>
		                <td><?php echo $row['cmnd']; ?></td>
		                <td><?php echo $row['tel']; ?></td>
		                <td><?php echo $row['gioitinh']; ?></td>
		                <td><?php echo $row['quoctich']; ?></td>
		                <td><?php echo $row['ngayden']; ?></td>

		                
		              

		            </tr>
        			<?php endwhile; ?>

		        </tbody>
		        
		    </table>   
	    </center> 

	</div>

</body>
</html>