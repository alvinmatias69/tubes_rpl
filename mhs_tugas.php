<!DOCTYPE html>
<html>

<head>
    <?php
        include 'cek_login.php';
        $error = "";
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
                    <li>
                        <a href="mhs_jadwal.php"><i class="fa fa-calendar fa-fw"></i>Jadwal</a>
                    </li>
                    <li>
                        <a href="mhs_materi.php"><i class="fa fa-book fa-fw"></i>Materi</a>
                    </li>
                    <li>
                        <a href="mhs_assessment.php"><i class="fa fa-tasks fa-fw"></i>Assessment</a>
                    </li>
                    <li class="selected">
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
                    <h1 class="page-header">Tugas</h1>
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
                            Upload file dalam bentuk rar / zip
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-materi">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>ID Assessment</th>
                                            <th>Soal</th>
                                            <th colspan="2">Jawaban</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include 'database.php';
                                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                                $data = array(
                                                    'id_assignment' => $_POST['id_assignment'], 
                                                    'link_jawaban'  => "",
                                                    'id_dosen'      => $_POST['id_dosen'],
                                                    'type'          => 'tugas',
                                                    'tanggal'       => date('Y-m-d'),
                                                    'id_mhs'        => $_SESSION['id_mhs']
                                                );
                                                $target_file = "tugas/" . $data['id_assignment'] . "." . basename($_FILES["file_jawaban"]["type"]);
                                                $type = pathinfo($target_file,PATHINFO_EXTENSION);
                                                if ($type != "zip" && $type != "rar") {
                                                    $error = "File yang diupload harus berekstensi .zip atau .rar";
                                                } else{
                                                    $data['link_jawaban'] = $target_file;
                                                    if(move_uploaded_file($_FILES['file_jawaban']['tmp_name'], $target_file)){
                                                        $sql = "insert into Assignment(id_assignment, type, tanggal, link_jawaban, id_mhs, id_dosen) values ('" . $data['id_assignment'] . "', '" . $data['type'] . "', '" . $data['tanggal'] . "', '" . $data['link_jawaban'] . "', '" . $data['id_mhs'] . "', '" . $data['id_dosen'] . "');";
                                                        try{
                                                            $conn->exec($sql);
                                                            $error = "Data berhasil diinput";
                                                            $sql = "insert into Kehadiran(tanggal, id_mhs) values ('" . $data['tanggal'] . "', '" . $data['id_mhs'] . "');";
                                                            $conn->exec($sql);
                                                        } catch(PDOException $e){
                                                            $error = "sudah pernah";
                                                        }
                                                    } else{
                                                        $error = "upload gagal";
                                                    }
                                                }                                              
                                                if($error != ""){
                                                    if ($error == "Data berhasil diinput") {
                                                        $tipe = "alert-success";
                                                        $str = "Sukses!";
                                                        $msg = " Jawaban berhasil diupload";
                                                    } else if($error == "sudah pernah"){
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
                                            }
                                            $sql = "select tanggal, link_soal, id_dosen, id_soal from Soal where substr(id_soal, 1, 2) = 'tg' and id_dosen = (select id_dosen_wali from Mahasiswa where id_mhs = '" . $_SESSION['id_mhs'] . "');";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                            if (! $result) {
                                                echo "<td colspan='4'>Data Kosong</td>";
                                            } else {
                                                do{
                                                	if ( ((int) date('YY') >= (int) substr($result['tanggal'], 0, 4)) && ((int) date('m') >= (int) substr($result['tanggal'], 6, 2)) && ((int) date('d') >= (int) substr($result['tanggal'], 8, 2)) ) {
	                                                    echo "<tr><td>" . $result['tanggal'] . "</td><td>";
	                                                    echo $result['id_soal'] . "</td>";
                                        ?>
                                        <td>
                                            <form method="post" action="download.php">
                                                <input type="hidden" name="dir" value="<?php echo $result['link_soal'] ?>">
                                                <input type="hidden" name="source" value="mhs_tugas.php">
                                                <button type="submit" class="btn btn-outline btn-primary"><i class="fa fa-download"></i> Download Soal</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">                                               
                                                <input type="file" name="file_jawaban" placeholder="link jawaban" required class="btn btn-outline btn-default">
                                                <input type="hidden" name="id_assignment" value="<?php echo 'tg' . $_SESSION['id_mhs'] . date('Y-m-d'); ?>">
                                                <input type="hidden" name="id_dosen" value="<?php echo $result['id_dosen'];?>">
                                        </td>
                                        <td>
                                                <button type="submit" class="btn btn-outline btn-primary"><i class="fa fa-upload"></i> Upload Jawaban</button>
                                            </form>
                                        </td>
                                        </td>
                                        <?php
                                    				}
                                                } while ($result = $stmt->fetch(PDO::FETCH_ASSOC));
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
