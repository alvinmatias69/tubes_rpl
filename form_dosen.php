<!DOCTYPE html>
<html>
<head>
	<title>Form Dosen</title>
	<?php
		include 'cek_login.php';
		$error = "";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			include 'database.php';
			$data = array(
				'id_dosen' 		=> htmlspecialchars($_POST["id_dosen"]), 
				'nama_dosen'	=> htmlspecialchars($_POST["nama_dosen"]),
				'password'		=> md5(htmlspecialchars($_POST["password"]))
			);
			$sql = "insert into Dosen(id_dosen,nama_dosen,password) values ('" . $data['id_dosen'] . "', '" . $data['nama_dosen'] . "', '" . $data['password'] . "');";
			try {
				$conn->exec($sql);
				$error = "Sukses Input Data";
			} catch (PDOException $e) {
				$error = "ID sudah ada!";
			}
		}		
	?>
</head>
<body>
	<h1>Input Data Dosen</h1>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<?php echo $error?><br>
		ID Dosen : <input type="number" name="id_dosen" min="1000000000" max="9999999999" required><br>
		Nama Dosen : <input type="text" name="nama_dosen" required><br>
		Password : <input type="password" name="password" required><br>
		<input type="submit" value="input"><br>
		<a href="panel_admin.php">Kembali ke menu</a>
	</form>
</body>
</html>