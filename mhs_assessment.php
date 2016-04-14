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
				'link_jawaban'	=> "",
				'id_dosen'		=> $_POST['id_dosen'],
				'type'			=> 'kuis',
				'tanggal'		=> date('d-m-y'),
				'id_mhs'		=> $_SESSION['id_mhs']
			);
			$target_file = "assessment/" . $data['id_assignment'] . "." . basename($_FILES["file_jawaban"]["type"]);
			$type = pathinfo($target_file,PATHINFO_EXTENSION);
			if ($type != "zip" && $type != "rar") {
				echo "File yang diupload harus berekstensi .zip atau .rar";
			} else{
				$data['link_jawaban'] = $target_file;
				if(move_uploaded_file($_FILES['file_jawaban']['tmp_name'], $target_file)){
					$sql = "insert into Assignment(id_assignment, type, tanggal, link_jawaban, id_mhs, id_dosen) values ('" . $data['id_assignment'] . "', '" . $data['type'] . "', '" . $data['tanggal'] . "', '" . $data['link_jawaban'] . "', '" . $data['id_mhs'] . "', '" . $data['id_dosen'] . "');";
					$conn->exec($sql);
					echo "Data berhasil diinput";
					$sql = "insert into Kehadiran(tanggal, id_mhs) values ('" . $data['tanggal'] . "', '" . $data['id_mhs'] . "');";
					$conn->exec($sql);
				} else{
					echo "upload gagal";
				}
			}
		}
		$sql = "select tanggal, link_soal, id_dosen from Soal where substr(id_soal, 1, 2) = 'as' and id_dosen = (select id_dosen_wali from Mahasiswa where id_mhs = '" . $_SESSION['id_mhs'] . "');";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (! $result) {
			echo "Data Kosong";
		} else {
			do{
				echo $result['tanggal'] . " ";
	?>
	<form method="post" action="download.php">
		<input type="hidden" name="dir" value="<?php echo $result['link_soal'] ?>">
		<input type="hidden" name="source" value="mhs_tugas.php">
		<input type="submit" value="Download">
	</form>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
		<input type="file" name="file_jawaban" placeholder="link jawaban" required>
		<input type="hidden" name="id_assignment" value="<?php echo 'as' . $result['id_dosen'] . $result['tanggal']; ?>">
		<input type="hidden" name="id_dosen" value="<?php echo $result['id_dosen'];?>">
		<input type="submit" value="input"><br>
	</form>
	<?php
			} while ($result = $stmt->fetch(PDO::FETCH_ASSOC));
		}
		
	?>
	<a href="panel_mhs.php">Kembali ke menu</a>
</body>
</html>