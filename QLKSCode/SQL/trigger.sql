--0. af_insert_sddv
create trigger af_insert_sddv
after insert on sudungdv
for each row
when (new.tongtien is null)
execute procedure tf_af_insert_sddv();

create or replace function tf_af_insert_sddv() returns trigger as
$$
declare
	giadv int:=0;
begin
	
	select dichvu.dongia into giadv
	from dichvu, sudungdv where dichvu.madv = new.madv;
	update sudungdv set tongtien = soluong*giadv
	where sudungdv.madv = new.madv and sudungdv.makh = new.makh and sudungdv.ngaysd = new.ngaysd;
	return new;
	
end;

$$
language plpgsql;





--1. af_update_sddv
create trigger af_update_sddv
after update of soluong on sudungdv
for each row
execute procedure tf_af_update_sddv();
create or replace function tf_af_update_sddv() returns trigger as
$$
declare
	giadv int:=0;
begin
	select dichvu.dongia into giadv
	from dichvu where dichvu.madv = new.madv;
	update sudungdv set tongtien = soluong*giadv
	where sudungdv.madv = new.madv and sudungdv.makh = new.makh and sudungdv.ngaysd = new.ngaysd;
	return new;
end;
$$
language plpgsql;


--2. af_update_tp
create trigger af_update_tp
after update of ngaydi on thuephong
for each row
execute procedure tf_af_update_tp();

create or replace function tf_af_update_tp() returns trigger as
$$
declare
	giap int:=0;
begin
	select phong.gia into giap
	from phong
	where phong.map = new.map;
	update thuephong set tongtien = (ngaydi-ngayden+1)*giap
	where thuephong.makh = new.makh and thuephong.map = new.map and thuephong.ngayden = new.ngayden;
	return new;
end;

$$
language plpgsql;

--3. af_insert_tp
create trigger af_insert_tp
after insert on thuephong
for each row
when (new.ngaydi is not null and new.tongtien is null)
execute procedure tf_af_insert_tp();


create or replace function tf_af_insert_tp() returns trigger as
$$
declare
	giap int:=0;
begin
	select phong.gia into giap
	from thuephong, phong where phong.map = new.map;
	update thuephong set tongtien = (ngaydi-ngayden+1)*giap
	where thuephong.makh = new.makh and thuephong.map = new.map and thuephong.ngayden = new.ngayden;
	return new;
end;
$$
language plpgsql;


--4. af_insert_hoadon
create trigger af_insert_hoadon
after insert on hoadon
for each row
execute procedure tf_af_insert_hoadon();

create or replace function tf_af_insert_hoadon() returns trigger as
$$
declare
	dv int:=0;
	ph int:=0;
	tc int:=0;
begin
	select sum(tongtien) into dv
	from sudungdv where sudungdv.makh = new.makh and thanhtoan = 0;
	if dv is null then dv = 0; end if;
	select sum(tongtien) into ph
	from thuephong where thuephong.makh = new.makh and thanhtoan = 0;
	if ph is null then ph = 0; end if;
	select sum(tiencoc) into tc
	from thuephong where thuephong.makh = new.makh and thanhtoan = 0;
	if tc is null then tc = 0; end if;
	update hoadon set tiendv = dv where hoadon.mahd = new.mahd;
	update hoadon set tienp = ph where hoadon.mahd = new.mahd;
	update hoadon set tiencoc = tc where hoadon.mahd = new.mahd;
	update hoadon set tienthue = dv/20 + ph/20 where hoadon.mahd = new.mahd;
	update hoadon set tongtientt = tienp + tiendv + tienthue where hoadon.mahd = new.mahd;
	update sudungdv set thanhtoan = 1 where sudungdv.makh = new.makh and thanhtoan = 0; 
	update thuephong set thanhtoan = 1 where thuephong.makh = new.makh and thanhtoan = 0;
	return new;
	
end;
$$
language plpgsql;

--5. af_insert_dp
create trigger af_insert_dp
after insert on doiphong
for each row
execute procedure tf_af_insert_dp();

create or replace function tf_af_insert_dp() returns trigger as
$$
declare
	ngay date;
	ngaydoip date;
begin
	select thuephong.ngaydi into ngay
	from thuephong 
	where thuephong.makh = new.makh and thuephong.map = new.mpcu and thanhtoan = 0 and thuephong.ngaydi >= new.ngaydoi and thuephong.ngayden <= new.ngaydoi;
	
	select doiphong.ngaydoi into ngaydoip
	from doiphong 
	where doiphong.makh = new.makh and doiphong.ngaydoi = new.ngaydoi and doiphong.mpcu = new.mpcu;
	
	update thuephong set ngaydi = ngaydoip - 1 
	where thuephong.makh = new.makh and thuephong.map = new.mpcu and thanhtoan = 0 and thuephong.ngaydi >= new.ngaydoi and thuephong.ngayden <= new.ngaydoi;
	insert into thuephong(makh, map, ngayden, ngaydi, tiencoc) values (new.makh, new.mpmoi, ngaydoip, ngay,0);
	return new;

end;
$$
language plpgsql;




