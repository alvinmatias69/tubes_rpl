<!DOCTYPE html>
<html>

<head>
    <?php
        include 'cek_login.php';
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'database.php';
            if ($_POST['tipe'] == 'tugas') {
                $type = 'tg';
            } else{
                $type = 'as';
            }
            $data = array(
                'id_soal'       => $type . $_SESSION['id_dosen'] . htmlspecialchars($_POST['tanggal']),
                'id_dosen'      => $_SESSION['id_dosen'], 
                'tanggal'       => htmlspecialchars($_POST['tanggal']),
                'link_soal'     => ""
            );
            $target_file =  "soal/" . $data['id_soal'] . basename($_FILES["file_soal"]["type"]);
            $type = pathinfo($target_file, PATHINFO_EXTENSION);
            if ($type != "pdf" && $type != "docx") {
                $error = "File yang diupload harus berekstensi .pdf atau .docx";
            } else{
                $data["link_soal"] = $target_file;
                $sql = "insert into Soal(id_soal, id_dosen, tanggal, link_soal) values('" . $data['id_soal'] . "', '" . $data['id_dosen'] . "', '" . $data['tanggal'] . "', '" . $data['link_soal'] . "');";
                try{
                    $conn->exec($sql);
                    $error = "input sukses";
                    move_uploaded_file($_FILES["file_soal"]["tmp_name"], $target_file);
                } catch (PDOException $e){
                    $error = "upload gagal";
                }
            }
        }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning || Dosen</title>
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
                                        $query = "select nama_dosen from Dosen where id_dosen = '" . $_SESSION['id_dosen'] . "';";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        echo $result['nama_dosen'];
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
                        <a href="dosen_jadwal.php"><i class="fa fa-calendar fa-fw"></i>Jadwal</a>
                    </li>
                    <li class="active">
                        <a href="#"><i class="fa fa-upload fa-fw"></i>Upload<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="dosen_materi.php">Upload Materi</a>
                            </li>
                            <li class="selected">
                                <a href="dosen_soal.php">Upload Soal</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil-square-o fa-fw"></i>Koreksi<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="dosen_tugas.php">Koreksi Tugas</a>
                            </li>
                            <li>
                                <a href="dosen_assessment.php">Koreksi Assessment</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="list_mahasiswa.php"><i class="fa fa-list-ul fa-fw"></i>List Mahasiswa</a>
                    </li>
                    <li>
                        <a href="list_kehadiran.php"><i class="fa fa-list-alt fa-fw"></i>Kehadiran Mahasiswa</a>
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
                    <h1 class="page-header">Upload Soal</h1>
                </div>
                 <!-- end page header-->
                 <div class="row">
                    <!--End Moving Line Chart -->
                <!-- </div> -->
                <div class="col-lg-12">
                    <!-- Bar Chart -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Materi yang diupload harus berekstensi .pdf atau .docx
                        </div>
                        <div class="panel-body">
                        	<div class="col-lg-4">
	                        	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" role="form">
							        <div class="form-group">
							        	<label>Tipe</label>
							        	<select name="tipe" class="form-control">
								            <option value="tugas">tugas</option>
								            <option value="assessment">assessment</option>
								        </select>
							        </div>
							        <div class="form-group">
							        	<label>Tanggal Dilaksanakan</label>
							        	<input type="date" name="tanggal" required class="form-control">
							        </div>
							        <div class="form-group">
							        	<label>File Soal</label>
							        	<input type="file" name="file_soal" placeholder="link soal" required class="btn btn-outline btn-default">
							        </div>
							        <div class="form-group">
							        	<button type="submit" class="btn btn-outline btn-primary"><i class="fa fa-upload"></i> Upload Soal</button>
							        </div>
							    </form>
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
