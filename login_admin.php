<!DOCTYPE html>
<html>
<head>
	<title>Login Admin</title>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			include 'database.php';
			$data = array(
				'id_admin' => htmlspecialchars($_POST['id_admin']), 
				'password' => md5(htmlspecialchars($_POST['password']))
			);
			$sql = "select * from Admin where id_admin = '" . $data['id_admin'] . "' and password = '" . $data['password'] . "';";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if (! $result) {
				$error = "ID atau Password salah";
			} else{
				session_start();
				$_SESSION['login'] = true;
				$_SESSION['id_admin'] = $data['id_admin'];
				echo "<meta http-equiv='refresh' content='0;url=panel_admin.php'>";
			}
		}
	?>
</head>
<body>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		ID Admin : <input type="text" name="id_admin" required=""><br>
		password : <input type="password" name="password" required><br>
		<input type="submit" value="login">
	</form>
</body>
</html>