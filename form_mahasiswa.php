<!DOCTYPE html>
<html>
<head>
	<title>Form Mahasiswa</title>
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
<body style="color: #444">
	<div class="container">
		<div class="page-header">
			<div class="row">
				<div class="col-md-3">
					<h1>Panel Admin</h1>
				</div>
				<div class="col-md-5"> </div>
				<div class="col-md-1">
					<a href="logout.php" class="btn btn-primary" style="float:right;">Logout <span class="glyphicon glyphicon-off"></span></a>
				</div>	
			</div>
		</div>
		<div class="row">
			
		</div>
		<div class="row">
			<div class="col-md-3">

				<h3>Selamat datang <?php echo $_SESSION['id_admin']?></h3>
				<div class="container-fluid">
					<ul class="nav nav-pills nav-stacked">
						<li class="active"><a href="form_mahasiswa.php"><span class="glyphicon glyphicon-user"></span> Form Mahasiswa</a></li>
						<li><a href="form_dosen.php"><span class="glyphicon glyphicon-education"></span> Form Dosen</a></li>
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
				<h2>Input Data Mahasiswa</h2>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form">
					<div class="">
						<label for="id_mhs">ID Mahasiswa :</label>
						<input type="number" placeholder="ID Mahasiswa" class="form-control input-md" name="id_mhs" min="1000000000" max="9999999999" required><br>
						<label for="password">Password :</label>
						<input type="password" placeholder="Password" class="form-control input-md" name="password" required><br>
						<label for="nama_mhs">Nama :</label>
						<input type="text" placeholder="Nama Mahasiswa" class="form-control input-md" name="nama_mhs" required><br>
						<label for="angkatan">Angkatan :</label>
						<input type="number" placeholder="Angkatan Mahasiswa" class="form-control input-md" name="angkatan" min="2010" max="3000" required><br>
						<label for="id_dosen">ID Dosen Wali : </label>
						<select class="form-control input-md" name="id_dosen">
						<?php
							include 'database.php';
							$sql = "select id_dosen, nama_dosen from Dosen;";
							$stmt = $conn->prepare($sql);
							$stmt->execute();
							while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
								echo "<option value='" . $result['id_dosen'] . "'>(" . $result['id_dosen'] . ") " . $result['nama_dosen'] . "</option>";
							}
						?>
						</select><br>
						<input type="submit" class="btn btn-primary btn-block btn-lg" value="Input"><br>
					</div>
				</form>		
			</div>
		</div>
		<!-- <a href="panel_admin.php">Kembali ke menu</a> -->
	</div>
</body>
</html>