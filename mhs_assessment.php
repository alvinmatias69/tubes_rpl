<!DOCTYPE html>
<html>
<head>
	<title>List Assessment</title>
	<?php include 'cek_login.php'; ?>
</head>
<body>
	<h1>List Assessment</h1>
	<?php
		include 'database.php';
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data = array(
				'id_assignment' => $_POST['id_assignment'], 
				'link_jawaban'	=> htmlspecialchars($_POST['link_jawaban']),
				'id_dosen'		=> $_POST['id_dosen'],
				'type'			=> 'kuis',
				'tanggal'		=> date('d-m-y'),
				'id_mhs'		=> $_SESSION['id_mhs']
			);
			$sql = "insert into Assignment(id_assignment, type, tanggal, link_jawaban, id_mhs, id_dosen) values ('" . $data['id_assignment'] . "', '" . $data['type'] . "', '" . $data['tanggal'] . "', '" . $data['link_jawaban'] . "', '" . $data['id_mhs'] . "', '" . $data['id_dosen'] . "');";
			$conn->exec($sql);
			echo "Data berhasil diinput";
			$sql = "insert into Kehadiran(tanggal, id_mhs) values ('" . $data['tanggal'] . "', '" . $date['id_mhs'] . "');";
			$conn->exec($sql);
		}
		$sql = "select tanggal, link_materi, id_dosen from Soal where substr(id_soal, 1, 2) = 'as' and id_dosen = (select id_dosen_wali from Mahasiswa where id_mhs = '" . $_SESSION['id_mhs'] . "');";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (! $result) {
			echo "Data Kosong";
		} else {
			do{
				echo $result['tanggal'] . " ";
				echo $result['link_materi'] . " ";
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<input type="text" name="link_jawaban" placeholder="link jawaban" required>
		<input type="hidden" name="id_assignment" value="<?php echo 'as' . $result['id_dosen'] . $result['tanggal']; ?>">
		<input type="hidden" name="id_dosen" value="<?php echo $_result['id_dosen'];?>">
		<input type="submit" value="input"><br>
	</form>
	<?php
			} while ($result = $stmt->fetch(PDO::FETCH_ASSOC));
		}
		
	?>
	<a href="panel_mhs.php">Kembali ke menu</a>
</body>
</html>