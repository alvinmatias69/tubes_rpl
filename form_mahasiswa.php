<!DOCTYPE html>
<html>
<head>
	<title>Form Mahasiswa</title>
	<?php
		include 'cek_login.php';
		$error = "";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			include 'database.php';
			$data = array(
				'id_mhs' 		=> htmlspecialchars($_POST['id_mhs']), 
				'nama_mhs' 		=> htmlspecialchars($_POST['nama_mhs']),
				'angkatan' 		=> htmlspecialchars($_POST['angkatan']),
				'id_dosen_wali' => htmlspecialchars($_POST['id_dosen']),
				'password'		=> md5(htmlspecialchars($_POST['password']))
			);
			$sql = "insert into Mahasiswa(id_mhs, nama_mhs, angkatan, id_dosen_wali, password) values ('" . $data['id_mhs'] . "', '" . $data['nama_mhs'] . "', '" . $data['angkatan'] . "', '" . $data['id_dosen_wali'] . "', '" . $data['password'] . "');";
			try {
				$conn->exec($sql);
				$error = "Input sukses";
			} catch (PDOException $e) {
				$error = "ID Mahasiswa sudah ada";
			}
		}
		
	?>
</head>
<body>
	<h1>Input Data Mahasiswa</h1>
	<?php echo $error; ?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		ID Mahasiswa : <input type="number" name="id_mhs" min="1000000000" max="9999999999" required><br>
		Password : <input type="password" name="password" required><br>
		Nama Mahasiswa : <input type="text" name="nama_mhs" required><br>
		Angkatan : <input type="number" name="angkatan" min="2010" max="3000" required><br>
		ID Dosen Wali :
		<select name="id_dosen">
		<?php
			include 'database.php';
			$sql = "select id_dosen, nama_dosen from Dosen;";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				echo "<option value='" . $result['id_dosen'] . "'>(" . $result['id_dosen'] . ")" . $result['nama_dosen'] . "</option>";
			}
		?>
		</select><br>
		<!-- ID Dosen Wali : <input type="text" name="id_dosen" required><br> -->
		<input type="submit" value="Input"><br>
		<a href="panel_admin.php">Kembali ke menu</a>
	</form>
</body>
</html>