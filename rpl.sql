create table if not exists Dosen (
	id_dosen int(10) not null,
	nama_dosen varchar(30) default null,
	password varchar(50) default null,
	constraint pk_Dosen primary key(id_dosen)
);

create table if not exists Mahasiswa(
	id_mhs int(10) not null,
	nama_mhs varchar(30) default null,
	angkatan int(4) default null,
	id_dosen_wali int(10) not null,
	password varchar(50) default null,
	constraint pk_Mahasiswa primary key(id_mhs),
	constraint fk_Mahasiswa foreign key(id_dosen_wali) references Dosen(id_dosen)
);

create table if not exists Nilai(
	id_penilaian int(10) not null,
	nilai int(3) default null,
	indeks varchar(2) default null,
	id_mhs int(10) not null,
	id_dosen int(10) not null,
	constraint pk_Nilai primary key(id_penilaian),
	constraint fk_Nilai_1 foreign key(id_mhs) references Mahasiswa(id_mhs),
	constraint fk_Nilai_2 foreign key(id_dosen) references Dosen(id_dosen)
);

create table if not exists Kehadiran(
	tanggal date default null,
	id_mhs int(10) not null,
	constraint fk_Kehadiran foreign key(id_mhs) references Mahasiswa(id_mhs)
);

create table if not exists Materi(
	id_materi int(10) not null auto_increment,
	tanggal date default null,
	link_materi varchar(50),
	id_dosen int(10) not null,
	constraint pk_Materi primary key(id_materi),
	constraint fk_Materi foreign key(id_dosen) references Dosen(id_dosen)
);

create table if not exists Jadwal(
	tanggal date default null,
	id_materi int(10) not null, 
	id_mhs int(10) not null,
	constraint fk_Jadwal_1 foreign key(id_materi) references Materi(id_materi),
	constraint fk_Jadwal_2 foreign key(id_mhs) references Mahasiswa(id_mhs)
);

create table if not exists Soal(
	id_soal varchar(22) not null,
	tanggal date default null,
	link_soal varchar(50) default null,
	id_dosen int(10) not null,
	constraint pk_Soal primary key(id_soal),
	constraint fk_Soal foreign key(id_dosen) references Dosen(id_dosen)
);

create table if not exists Assignment(
	id_assignment varchar(22) not null,
	type varchar(5) default null,
	tanggal date default null,
	nilai int(3) default null,
	link_jawaban varchar(50) default null,
	id_mhs int(10) not null,
	id_dosen int(10) not null,
	constraint pk_Assignment primary key(id_assignment),
	constraint fk_Assignment_1 foreign key(id_mhs) references Mahasiswa(id_mhs),
	constraint fk_Assignment_2 foreign key(id_dosen) references Dosen(id_dosen)
);

create table if not exists Admin(
	id_admin char(5) not null,
	password varchar(50) not null,
	constraint pk_Admin primary key(id_admin)
);