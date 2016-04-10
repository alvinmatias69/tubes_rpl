<!DOCTYPE html>
<html>
<head>
	<title>Form Dosen</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
	<div class="container">
		<!-- <div class="page-header"> -->
			<!-- <div class="row page-header"> -->	
			<!-- </div> -->
		<!-- </div> -->
		<div class="row">
			<div class="col-md-3">
				<h1>Panel Admin</h1>
			</div>
			<div class="col-md-5"> </div>
			<div class="col-md-1">
				<br>
				<a href="logout.php" class="btn btn-primary" style="float:right;">Logout <span class="glyphicon glyphicon-off"></span></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">

				<h3>Selamat datang <?php echo $_SESSION['id_admin']?></h3>
				<div class="container-fluid">
					<ul class="nav nav-pills nav-stacked">
						<li><a href="form_mahasiswa.php"><span class="glyphicon glyphicon-user"></span> Form Mahasiswa</a></li>
						<li class="active"><a href="form_dosen.php"><span class="glyphicon glyphicon-education"></span> Form Dosen</a></li>
						<li><a href="form_jadwal.php"><span class="glyphicon glyphicon-calendar"></span> Form Jadwal</a></li>
					</ul>					
				</div>
			</div>
			<?php
				if($error != ""){
					if ($error == "Input sukses") {
						$tipe = "alert-success";
						$str = "Sukses!";
						$msg = " Data berhasil diinput";
					} else{
						$tipe = "alert-danger";
						$str = "Gagal!";
						$msg = " ID mahasiswa sudah ada!";
					}
					echo '
					<div class="col-md-5">
						<div class="alert ' . $tipe . ' fade in">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>' . $str . '</strong>' . $msg . ' 
						</div>
					</div> ';
				}
			?>
			<div class="col-md-1"> </div>
			<div class="col-md-5 well well-md">
				<h2>Input Data Dosen</h2>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form">
					<div class="form-group">
						<label for="id_dosen">ID Dosen :</label>
						<input type="number" name="id_dosen" min="1000000000" max="9999999999" required class="form-control input-md" placeholder="ID Dosen">	
					</div>
					<div class="form-group">
						<label for="nama_dosen">Nama Dosen :</label>
						<input type="text" name="nama_dosen" required class="form-control input-md" placeholder="Nama Dosen">	
					</div>
					<div class="form-group">
						<label for="password">Password :</label>
						<input type="password" name="password" required class="form-control input-md" placeholder="Password">	
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-block btn-lg" value="Input">
					</div>
				</form>		
			</div>
		</div>
		<!-- <a href="panel_admin.php">Kembali ke menu</a> -->
	</div>
</body>
</html>