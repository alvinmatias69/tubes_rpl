<!DOCTYPE html>
<html>

<head>
    <?php
        include 'cek_login.php';
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'database.php';
            $target_file = "materi/" . $_SESSION['id_dosen'] . date('Y-m-d') . basename($_FILES["file_materi"]["type"]);
            $type = pathinfo($target_file,PATHINFO_EXTENSION);
            if ($type != "pdf" && $type != "docx" && $type != "pptx") {
                $error = "File yang diupload harus berekstensi .pdf, .docx, atau .pptx";
            } else{
                if (move_uploaded_file($_FILES["file_materi"]["tmp_name"],$target_file)) {
                    $data = array(
                        'tanggal'       => date('Y-m-d'), 
                        'link_materi'   => $target_file,
                        'id_dosen'      => $_SESSION['id_dosen']
                    );
                    try{
	                    $sql = "insert into Materi(tanggal, link_materi, id_dosen) values('" . $data['tanggal'] . "', '" . $data['link_materi'] . "', '" . $data['id_dosen'] . "');";
	                    $conn->exec($sql);
	                    $error = "input sukses";  
	                } catch(PDOException $e){
	                	$error = "upload gagal";
	                }
                } else{
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
                            <li class="selected">
                                <a href="dosen_materi.php">Upload Materi</a>
                            </li>
                            <li>
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
                    <h1 class="page-header">Upload Materi</h1>
                </div>
                 <!-- end page header-->
                 <div class="row">
                <!-- </div> -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Materi yang diupload harus berekstensi .pdf, .docx, atau .pptx
                        </div>
                        <div class="panel-body">
                        	<?php
                        		if($error != ""){
                                    if ($error == "input sukses") {
                                        $tipe = "alert-success";
                                        $str = "Sukses!";
                                        $msg = " Jawaban berhasil diupload";
                                    } else if($error == "upload gagal"){
                                        $tipe = "alert-danger";
                                        $str = "Gagal!";
                                        $msg = " Anda sudah mengunggah tugas ini sebelumnya";
                                    } else{
                                        $tipe = "alert-danger";
                                        $str = "Gagal!";
                                        $msg = " File yang diupload harus berekstensi .zip atau .rar";
                                    }
                                    echo '
                                        <div class="col-lg-12">
	                                        <div class="alert ' . $tipe . ' fade in">
    			                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                		                        <strong>' . $str . '</strong>' . $msg . ' 
                                            </div>
                                        </div> ';
                                }
                        	?>
                        	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                                <label>File Materi</label>
                        		<input type="file" name="file_materi" placeholder="link materi" required class="btn btn-outline btn-default"><br>
                        		<button type="submit" class="btn btn-outline btn-primary"><i class="fa fa-upload"></i> Upload Materi</button>
                        		<!-- <input type="file" name="file_materi" required><br> -->
						        <!-- <input type="submit" value="input"> -->
						    </form>
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
