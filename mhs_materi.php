<!DOCTYPE html>
<html>
<head>
	<title>List Materi</title>
	<?php include 'cek_login.php'; ?>
</head>
<body>
	<h1>Daftar Materi</h1>
	<?php
		include 'database.php';
		$sql = "select * from Materi where id_dosen = ( select id_dosen_wali from Mahasiswa where id_mhs = '" . $_SESSION['id_mhs'] . "');";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (! $result) {
			echo "Data Kosong";
		} else {
			do{
				echo $result['id_materi'] . " ";
				echo $result['tanggal'] . " ";
				echo $result['link_materi'] . "<br>";
			} while($result = $stmt->fetch(PDO::FETCH_ASSOC));
		}
	?>
	<br>
	<a href="panel_mhs.php">Kembali ke menu</a>
</body>
</html>