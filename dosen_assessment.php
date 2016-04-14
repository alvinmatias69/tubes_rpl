<!DOCTYPE html>
<html>
<head>
	<title>List Assessment</title>
	<?php
		include 'cek_login.php';
	?>
</head>
<body>
	<?php
		include 'database.php';
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$nilai = htmlspecialchars($_POST['nilai']);
			$sql = "update Assignment set nilai = " . $nilai . " where id_assignment = '" . $_POST['id_assignment'] . "';";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			// $conn->exec($sql);
		}
		$sql = "select id_assignment, tanggal, id_mhs, link_jawaban, nilai from Assignment where substring(id_assignment,1,12) = 'as" . $_SESSION['id_dosen'] . "';";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (! $result) {
			echo "Data Kosong";
		} else{
			do {
				echo $result['tanggal'];
				echo $result['id_mhs'];
				echo $result['link_jawaban'];
	?>
	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="number" name="nilai" required min="0" max="100" placeholder="Nilai Baru" value="<?php echo $result['nilai']?>">
		<input type="hidden" name="id_assignment" value="<?php echo $result['id_assignment'] ?>">
		<input type="submit" value="submit"><br>
	</form>

	<?php
			} while($result = $stmt->fetch(PDO::FETCH_ASSOC));
		}
	?>
	<a href="panel_dosen.php">Kembali ke menu</a>
</body>
</html>