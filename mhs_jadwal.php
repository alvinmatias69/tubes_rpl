<!DOCTYPE html>
<html>

<head>
    <?php
        include 'cek_login.php';
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning || Mahasiswa</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
      <link href="assets/css/main-style.css" rel="stylesheet" />


</head>

<body>
   <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    <img src="assets/img/logo.png" alt="" />
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- main dropdown -->
                <li  class="tooltip-demo">
                    <a href="logout.php" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="fa fa-sign-out fa-3x"></i></a>
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->

        </nav>
        <!-- end navbar top -->

        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="user-section-inner">
                                <img src="assets/img/user.jpg" alt="">
                            </div>
                            <div class="user-info">
                                <div>
                                    <strong>
                                    <?php
                                        include 'database.php';
                                        $query = "select nama_mhs from Mahasiswa where id_mhs = '" . $_SESSION['id_mhs'] . "';";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        echo $result['nama_mhs'];
                                    ?>
                                    </strong></div>
                                <div class="user-text-online">
                                    <span class="user-circle-online btn btn-success btn-circle "></span>&nbsp;Online
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    <li>
                        <a href="mhs_nilai.php"><i class="fa fa-bar-chart fa-fw"></i>Nilai</a>
                    </li>
                    <li class="selected">
                        <a href="mhs_jadwal.php"><i class="fa fa-calendar fa-fw"></i>Jadwal</a>
                    </li>
                    <li>
                        <a href="mhs_materi.php"><i class="fa fa-book fa-fw"></i>Materi</a>
                    </li>
                    <li>
                        <a href="mhs_assessment.php"><i class="fa fa-tasks fa-fw"></i>Assessment</a>
                    </li>
                    <li>
                        <a href="mhs_tugas.php"><i class="fa fa-pencil-square-o fa-fw"></i>Tugas</a>
                    </li>

                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper" >
            <div class="row">
                <!-- page header-->
                <div class="col-lg-12">
                    <h1 class="page-header">Jadwal</h1>
                </div>
                 <!-- end page header-->
            </div>
            <div class="row">
                    <!--End Moving Line Chart -->
                <!-- </div> -->
                <div class="col-lg-12">
                    <!-- Bar Chart -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Jadwal Anda
                        </div>
                        <div class="panel-body">
                        	<h2>Jadwal Materi</h2>
                           	<div class="table-responsive">
                           		<table class="table table-striped table-bordered table-hover" id="table-materi">
                           			<thead>
                           				<tr>
                           					<th>Tanggal</th>
                           					<th>ID Materi</th>
                           					<th>Nama Dosen</th>	
                           				</tr>
                           			</thead>
                           			<tbody>
	                           				<?php
				                                include 'database.php';
				                                $sql = "select j.tanggal, id_materi, nama_dosen from Jadwal j join Materi m using (id_materi) join Dosen using (id_dosen) where id_dosen = (select id_dosen_wali from Mahasiswa where id_mhs = '" . $_SESSION['id_mhs'] . "');";
				                                $stmt = $conn->prepare($sql);
				                                $stmt->execute();
				                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
				                                if (! $result) {
				                                    echo "<td colspan='3'>Data kosong";
				                                } else {
				                                    do{
				                                        echo "<tr><td>" . $result['tanggal'] . "</td><td>";
				                                        echo $result['id_materi'] . "</td><td>";
				                                        echo $result['nama_dosen'] . "</td></tr>";
				                                    } while($result = $stmt->fetch(PDO::FETCH_ASSOC));
				                                }
				                            ?>						
                           			</tbody>
                           		</table>
                           	</div>
                           	<h2>Jadwal Assignment</h2>
                           	<div class="table-responsive">
                           		<table class="table table-striped table-bordered table-hover" id="table-assessment">
                           			<thead>
                           				<th>Tanggal</th>
                           				<th>Tipe</th>
                           				<th>Nama Dosen</th>
                           			</thead>
                           			<tbody>
                           					<?php
                           						include 'database.php';
                           						$sql = "select tanggal, type, nama_dosen from Assignment join Dosen using (id_dosen) where id_mhs = '" . $_SESSION['id_mhs'] . "';";
                           						$stmt = $conn->prepare($sql);
				                                $stmt->execute();
				                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
				                                if (! $result) {
				                                    echo "<td colspan='3'>Data kosong";
				                                } else {
				                                    do{
				                                        echo "<td>" . $result['tanggal'] . "</td><td>";
				                                        echo $result['type'] . "</td><td>";
				                                        echo $result['nama_dosen'] . "</td></tr>";
				                                    } while($result = $stmt->fetch(PDO::FETCH_ASSOC));
				                                }
                           					?>
                           			</tbody>
                           		</table>
                           	</div>
                        </div>
                    </div>
                     <!--End Bar Chart -->
                </div>
                
            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/flot/jquery.flot.js"></script>
    <script src="assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="assets/plugins/flot/jquery.flot.pie.js"></script>
    <script src="assets/scripts/flot-demo.js"></script>

</body>

</html>
