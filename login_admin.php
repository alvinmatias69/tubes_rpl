<!DOCTYPE html>
<html>
<head>
	<title>Login Admin</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
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
				echo "<meta http-equiv='refresh' content='0;url=form_mahasiswa.php'>";
			}
		}
	?>
</head>
<body>
	<div class="back">
		<div class="container ">
			<div class="row">
				<div class="col-md-3"> </div>
				<div class="col-md-5">
					<h1><strong>E-Learning</strong> Login Admin</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4"> </div>
				<div class="col-md-3 well well-sm">
					<form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
						<div class="form-group">
							<label for="id_admin">ID Admin</label>
							<input type="text" name="id_admin" required class="form-control">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" required class="form-control">
						</div>
						<input type="submit" class="btn btn-primary btn-block btn-lg" value="Input"><br>
					</form>		
				</div>
			</div>
		</div>
	</div>
</body>
</html>