<!DOCTYPE html>
<html>
<head>
	<title>Login Mahasiswa</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<?php
		$error = "";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			include 'database.php';
			$data = array(
				'id_mhs' 	=> htmlspecialchars($_POST['id_mhs']), 
				'password'	=> md5(htmlspecialchars($_POST['password']))
			);
			$sql = "select * from Mahasiswa where id_mhs = '" . $data['id_mhs'] . "' and password = '" . $data['password'] . "';";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if (! $result) {
				$error = "username atau password salah, coba lagi";
			} else {
				session_start();
				$_SESSION['login'] = true;
				$_SESSION['id_mhs'] = $data['id_mhs'];
				echo "<meta http-equiv='refresh' content='0;url=panel_mhs.php'>";
			}
			
		}		
	?>
</head>
<body>
	<h1>Login Mahasiswa</h1>
	<?php echo ""; ?>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
		ID Mahasiswa : <input type="number" name="id_mhs" required min="1000000000" max="9999999999"><br>
		Password : <input type="password" name="password" required><br>
		<input type="submit" value="login">
	</form>
</body>
</html>