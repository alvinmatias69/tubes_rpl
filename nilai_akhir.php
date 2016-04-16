<!DOCTYPE html>
<html>
<head>
	<?php
		include 'database.php';
		$query = "select * FROM( SELECT SUM(Nilai) ass FROM Assignment WHERE substring(id_assignment,1,2) = 'as' and id_mhs = '" . $result['id_mhs'] . "') AS tab1,(SELECT SUM(Nilai) tg FROM Assignment WHERE substring(id_assignment,1,2) = 'tg' and id_mhs = '" . $result['id_mhs'] . "') AS tab2;";
       	$statement = $conn->prepare($query);
       	$statement->execute();
       	$hasil = $statement->fetch(PDO::FETCH_ASSOC);
       	$nilai = round(($hasil['ass'] * 7 + $hasil['tg'] * 3)/10, 0);
       	if ($nilai < 31) {
       		$indeks = 'E';
       	} else if($nilai < 51){
       		$indeks = 'D';
       	} else if($nilai < 66){
       		$indeks = 'C';
       	} else if($nilai <76){
       		$indeks = 'B';
       	} else{
       		$indeks = 'A';
       	}
       	$query = "insert into Nilai(nilai, indeks, id_mhs, id_dosen) values (" . $nilai . ", '" . $indeks . "', '" . $result['id_mhs'] . "', '" . $_SESSION['id_dosen'] . "');";
       	$conn->exec($query);
       	echo "<meta http-equiv='refresh' content='0;url=list_mahasiswa.php'>";
	?>
</head>
<body>

</body>
</html>