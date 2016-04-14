<!DOCTYPE html>
<html>
<head>
	<title>Form Materi</title>
	<?php
		include 'cek_login.php';
		$message = "";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			include 'database.php';
			$target_file = "materi/" . $_SESSION['id_dosen'] . $_POST['tanggal'] . basename($_FILES["file_materi"]["type"]);
			$type = pathinfo($target_file,PATHINFO_EXTENSION);
			if ($type != "pdf" && $type != "docx" && $type != "pptx") {
				$message = "File yang diupload harus berekstensi .pdf, .docx, atau .pptx";
			} else{
				if (move_uploaded_file($_FILES["file_materi"]["tmp_name"],$target_file)) {
					$data = array(
						'tanggal' 		=> $_POST['tanggal'], 
						'link_materi'	=> $target_file,
						'id_dosen'		=> $_SESSION['id_dosen']
					);
					$sql = "insert into Materi(tanggal, link_materi, id_dosen) values('" . $data['tanggal'] . "', '" . $data['link_materi'] . "', '" . $data['id_dosen'] . "');";
					$conn->exec($sql);
					$message = "input sukses";	
				} else{
					$message = "upload gagal";
				}
				
			}
		}
	?>
</head>
<body>
	<h1>Input Materi</h1>
	<?php echo $message; ?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		Tanggal : <input type="date" name="tanggal" required><br>
		Link Materi : <input type="file" name="file_materi" required><br>
		<input type="submit" value="input"><br>
		<a href="panel_dosen.php">Kembali ke menu</a>
	</form>
</body>
</html>