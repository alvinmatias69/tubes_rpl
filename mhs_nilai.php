<!DOCTYPE html>
<html>
<head>
	<title>Daftar Nilai</title>
	<?php include 'cek_login.php'; ?>
</head>
<body>
	<h1>Daftar Nilai</h1>
	<?php
		include 'database.php';
		$sql = "select nilai, indeks from Nilai where id_mhs = '" . $_SESSION['id_mhs'] . "' and id_dosen = (select id_dosen_wali from Mahasiswa where id_mhs = '" . $_SESSION['id_mhs'] . "');";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (! $result) {
			echo "Nilai belum ada";
		} else {
			echo "Nilai : " . $result['nilai'] . "<br>";
			echo "Index : " . $result['index'];
		}
	?>
	<a href="panel_mhs.php">Kembali ke menu</a>
</body>
</html>