create table khachhang(
	makh serial primary key,
	hoten varchar(30) not null,
	diachi varchar(30) not null,
	cmnd varchar(12) not null unique,
	tel varchar(12) not null,
	gioitinh varchar(10) not null,
	quoctich varchar(30) not null
);

create table dichvu(
	madv char(4) not null primary key,
	tendv varchar(30) not null,
	loaidv varchar(30) not null,
	dongia int not null,
	trangthai int default 1
);

create table phong(
	map char(4) not null primary key,
	kieup varchar(12) not null,
	loaip varchar(12) not null,
	gia int not null,
	trangthai int default 1
);

create table hoadon(
	mahd SERIAL primary key,
	makh int not null,
	ngaytt date not null,
	hinhthuctt varchar(30),
	tongtientt int,
	tienp int,
	tiendv int,
	tienthue int,
	tiencoc int
);

create table quanly(
	username varchar(50) not null primary key,
	password varchar(30) not null,
	hoten varchar(30) not null,
	gioitinh varchar(10) not null,
	chucvu varchar(30) not null
);

create table sudungdv(
	makh int not null,
	madv char(4) not null,
	ngaysd date not null,
	soluong int not null,
	tongtien int,
	thanhtoan int default 0
);
create table thuephong(
	makh int not null,
	map char(4) not null,
	ngayden date not null,
	ngaydi date,
	tiencoc int not null,
	tongtien int,
	thanhtoan int default 0
	
);

create table doiphong(
	makh int,
	map int,
	mpcu char(4),
	mpmoi char(4) not null
);


alter table sudungdv add primary key (makh, madv, ngaysd);
alter table thuephong add primary key (makh, map, ngayden);
alter table doiphong add primary key (makh, map, mpcu);
alter table doiphong add foreign key (makh) references khachhang(makh) on delete cascade;
alter table doiphong add foreign key (mapcu) references phong(map) on delete casecade;
alter table doiphong add foreign key (mapmoi) references phong(map) on delete casecade;

alter table sudungdv add foreign key (makh) references khachhang(makh) on delete cascade;
alter table sudungdv add foreign key (madv) references dichvu(madv) on delete cascade;
alter table thuephong add foreign key (makh) references khachhang(makh) on delete cascade;
alter table thuephong add foreign key (map) references phong(map) on delete cascade;
alter table hoadon add foreign key (makh) references khachhang(makh) on delete cascade;






