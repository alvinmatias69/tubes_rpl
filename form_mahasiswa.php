<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning || Admin</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />

    <?php
        include 'cek_login.php';
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include 'database.php';
            $data = array(
                'id_mhs'        => htmlspecialchars($_POST['id_mhs']), 
                'nama_mhs'      => htmlspecialchars($_POST['nama_mhs']),
                'angkatan'      => htmlspecialchars($_POST['angkatan']),
                'id_dosen_wali' => htmlspecialchars($_POST['id_dosen']),
                'password'      => md5(htmlspecialchars($_POST['password']))
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
                                <div><strong>Admin</strong> <?php echo $_SESSION['id_admin']; ?></div>
                                <div class="user-text-online">
                                    <span class="user-circle-online btn btn-success btn-circle "></span>&nbsp;Online
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    <li class="selected">
                        <a href="form_mahasiswa.php"><i class="fa fa-user fa-fw"></i>Form Mahasiswa</a>
                    </li>
                     <li>
                        <a href="form_dosen.php"><i class="fa fa-graduation-cap fa-fw"></i>Form Dosen</a>
                    </li>
                     <li>
                        <a href="form_jadwal.php"><i class="fa fa-calendar fa-fw"></i>Form Jadwal</a>
                    </li>
                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Form Mahasiswa</h1>
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
                        <div class="col-lg-12">
                            <div class="alert ' . $tipe . ' fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>' . $str . '</strong>' . $msg . ' 
                            </div>
                        </div> ';
                    }
                ?>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Input Data Mahasiswa
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form">
                                        <div class="form-group">
                                            <label>Id Mahasiswa</label>
                                            <input class="form-control" placeholder="ID Mahasiswa" type="number" min="1000000000" max="9999999999" required name="id_mhs">
                                        </div>

                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" placeholder="Nama Mahasiswa" class="form-control input-md" name="nama_mhs" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" placeholder="Password" class="form-control input-md" name="password" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Angkatan</label>
                                            <input type="number" placeholder="Angkatan Mahasiswa" class="form-control input-md" name="angkatan" min="2010" max="3000" required>
                                        </div>

                                         <div class="form-group">
                                            <label>Id Dosen Wali</label>
                                            <select class="form-control input-md" name="id_dosen">
                                                <option disabled value="pilihan" selected>Pilih Dosen</option>
                                                <?php
                                                    include 'database.php';
                                                    $sql = "select id_dosen, nama_dosen from Dosen;";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();
                                                    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                        echo "<option value='" . $result['id_dosen'] . "'>(" . $result['id_dosen'] . ") " . $result['nama_dosen'] . "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Input">
                                        <button type="reset" class="btn btn-success">Reset</button>
                    </div>
                     <!-- End Form Elements -->
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

</body>

</html>
