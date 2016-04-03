<!DOCTYPE html>
<html>
<head>
	<title>Form Materi</title>
	<?php
		include 'cek_login.php';
		$message = "";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			include 'database.php';
			$data = array(
				'tanggal' 		=> $_POST['tanggal'], 
				'link_materi'	=> $_POST['link_materi'],
				'id_dosen'		=> $_SESSION['id_dosen']
			);
			$sql = "insert into Materi(tanggal, link_materi, id_dosen) values('" . $data['tanggal'] . "', '" . $data['link_materi'] . "', '" . $data['id_dosen'] . "');";
			$conn->exec($sql);
			$message = "input sukses";
		}
	?>
</head>
<body>
	<h1>Input Materi</h1>
	<?php echo $message; ?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		Tanggal : <input type="date" name="tanggal" required><br>
		Link Materi : <input type="text" name="link_materi"><br>
		<input type="submit" value="input"><br>
		<a href="panel_dosen.php">Kembali ke menu</a>
	</form>
</body>
</html>