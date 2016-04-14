<!DOCTYPE html>
<html>
<head>
	<title>Form Jadwal</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<?php 
		include 'cek_login.php';
		$error = "";
		if ($_SERVER["REQUEST_METHOD"] == 'post') {
			include 'database.php';
			$data = array(
				'tanggal'   => htmlspecialchars($_Post['tanggal']), 
				'id_materi' => htmlspecialchars($_Post['id_materi']),
				'id_mhs' 	=> htmlspecialchars($_Post['id_mhs'])
			);
			$sql = "insert into Jadwal(tanggal, id_materi, id_mhs) values ('". $data['tanggal'] . "', '" . $data['id_materi'] . "', '" . $data['id_mhs'] . "');";
			try {
				$conn->exec($sql);
			} catch (PDOException $e) {
				$error = "ini belum selesai";
			}
		}
	?>
</head>
<body>
	<div class="container">
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
						<li><a href="form_dosen.php"><span class="glyphicon glyphicon-education"></span> Form Dosen</a></li>
						<li class="active"><a href="form_jadwal.php"><span class="glyphicon glyphicon-calendar"></span> Form Jadwal</a></li>
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
				<h2>Input Data Jadwal</h2>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form">
					<div class="form-group">
						<label for="tanggal">Tanggal :</label>
						<input type="date" name="tanggal" required class="form-control input-md" placeholder="tanggal">
					</div>
					<div class="form-group">
						<label for="id_materi">ID Materi :</label>
						<select name="id_materi" class="form-control input-md">
							<?php
								include 'database.php';
								$sql = "select id_materi from Materi";
								$stmt = $conn->prepare($sql);
								$stmt->execute();
								if (! $result = $stmt->fetch(PDO::FETCH_ASSOC)) {
									// echo "</select>asdaf";
									echo "<option disabled=disabled>Tidak ada data</option>";
								} else{
									echo "<option value='" . $result['id_materi'] . "'>" . $result['id_materi'] . "</option>";
								} while($result = $stmt->fetch(PDO::FETCH_ASSOC));
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="id_mhs">ID Mahasiswa :</label>
						<select name="id_mhs" class="form-control input-md">
							<?php
								include 'database.php';
								$sql = "select id_mhs, nama_mhs from Mahasiswa";
								$stmt = $conn->prepare($sql);
								$stmt->execute();
								if (! $result = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<option disabled=disabled>Tidak ada data</option>";
								} else{
									do{
										echo "<option value='" . $result['id_mhs'] . "'>(" . $result['id_mhs'] . ") " . $result['nama_mhs'] . "</option>";
									}while($result = $stmt->fetch(PDO::FETCH_ASSOC));
								} 
							?>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-block btn-lg" value="Input">
					</div>
				</form>		
			</div>
		</div>
	</div>
</body>
</html>