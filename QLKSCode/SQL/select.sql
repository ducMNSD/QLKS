--1. các phòng đang được sử dụng từ ngày x đến ngày y
select phong.*
from phong, thuephong
where phong.map = thuephong.map
and ((thuephong.ngayden >= '2018-12-06' and thuephong.ngayden <= '2018-12-10') or (thuephong.ngaydi >= '2018-12-06' and thuephong.ngaydi <= '2018-12-10' ))


--2. các phòng có thể đặt từ ngày x đến ngày y
(select phong.* from phong)
EXCEPT
(select distinct phong.*
from phong, thuephong
where phong.map = thuephong.map
and ((thuephong.ngayden >= '2018-12-06' and thuephong.ngayden <= '2018-12-10') or (thuephong.ngaydi >= '2018-12-06' and thuephong.ngaydi <= '2018-12-10' )))
order by map asc



--3. các phòng được sử dụng trong ngày x đến ...(Dành cho khách đặt ngày đi không biết trước)

select distinct ph.*
from phong ph, thuephong tp 
where ph.map = tp.map
and ((tp.ngayden <= '2018-12-06' and tp.ngaydi >= '2018-12-06') or tp.ngayden >= '2018-12-06')

--4. các phòng có thể đặt được từ ngày x (Dành cho khách đặt ngày đi không biết trước)
select * from phong
EXCEPT
(select distinct ph.*
from phong ph, thuephong tp 
where ph.map = tp.map
and ((tp.ngayden <= '2018-12-06' and tp.ngaydi >= '2018-12-06') or tp.ngayden >= '2018-12-06'))
order by map asc

--5. số lượng nam nữ
select kh.gioitinh, count(*) as soluong
from khachhang kh
group by gioitinh

--6. khách hàng lưu trú liên tục lâu nhất
select distinct kh.*,ngayden, ngaydi, (ngaydi - ngayden + 1) as songay
from khachhang kh, thuephong tp
where kh.makh = tp.makh
and (ngaydi - ngayden + 1) = (select max(ngaydi - ngayden + 1) from khachhang, thuephong where khachhang.makh = thuephong.makh)

--7. khách hàng sử dụng nhiều dịch vụ nhất
with bang as(
select distinct makh, madv
from sudungdv	
)
select kh.*, count(*) as soluong
from bang, khachhang kh
where kh.makh = bang.makh
group by kh.makh
having count(*) >= ALL(select count(*) from bang group by makh)

--8. khách hàng có tổng tiền dịch vụ lớn nhất năm 2019

select kh.*, sum(tongtien) as tongtiendv
from khachhang kh, sudungdv sddv
where kh.makh = sddv.makh 
group by kh.makh
having sum(tongtien) >= ALL(select sum(tongtien) from sudungdv group by makh)

--9. khách hàng có tổng tiền hóa đơn lớn nhất

select kh.*, sum(tongtientt) as tongtien
from khachhang kh, hoadon hd
where kh.makh = hd.makh
group by kh.makh
having sum(tongtientt) >= all(select sum(tongtientt) from hoadon group by makh)

--10. Dịch vụ được yêu cầu nhiều nhất
select sddv.madv, tendv, loaidv, (dongia || ' đ') as dongia, count(*) as solan
from sudungdv sddv, dichvu dv
where sddv.madv = dv.madv
group by sddv.madv, tendv, loaidv, dongia
having count(*) >= ALL (select count(*) from sudungdv group by madv)

--11. Dịch vụ được tiêu thụ nhiều nhất
SELECT madv, tendv, loaidv,(dongia||'đ') as dongia,sum(sddv.soluong) as soluong
from sudungdv as sddv
natural join dichvu as dv
group by madv , tendv,dongia, loaidv
having sum(sddv.soluong) >= all (select sum(sddv.soluong)
from sudungdv as sddv group by madv)

--12. DỊch vụ giải trí - thư giãn được yêu cầu nhiều nhất
select sddv.madv, tendv, loaidv, (dongia || ' đ') as dongia, count(*) as solan
from sudungdv sddv, dichvu dv
where sddv.madv = dv.madv and loaidv = 'Giải trí - Thư giãn'
group by sddv.madv, tendv, loaidv, dongia
having count(*) >= ALL (select count(*) from sudungdv where loaidv = 'Giải trí - Thư giãn' group by madv)

--13. Tháng có nhiều khách đến nhất
with bang as(
select distinct makh, date_part('month', ngayden) as thangden
from thuephong
where date_part('year', ngayden) = 2019	
)
select thangden, count(*) as soluongkhach
from bang
group by thangden
having count(*) >= ALL(select count(*) from bang group by thangden)
















