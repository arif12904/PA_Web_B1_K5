create table akun (
id_akun int(3) not null auto_increment,
username_akun varchar(25) not null,
password_akun varchar(255) not null,
foto_akun varchar(255),
primary key(id_akun)
)auto_increment = 1;

create table makanan(
id_makanan int(3) not null auto_increment,
judul_makanan varchar(50) not null,
deskripsi_makanan varchar(2000) not null,
foto_makanan varchar(255) not null,
rating_makanan double(3,1) not null,
tanggal_upload date not null,
status_report varchar(25),
id_akun int(3) not null,
primary key (id_makanan),
constraint fk_akun foreign key (id_akun) references akun(id_akun)
)auto_increment = 1;

create table komentar(
id_komentar int(3) not null auto_increment,
id_makanan int(3) not null,
isi_komentar varchar(255) not null,
tanggal_komentar date not null,
primary key(id_komentar),
constraint fk_makanan foreign key (id_makanan) references makanan(id_makanan)
)auto_increment = 1;