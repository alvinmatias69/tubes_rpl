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
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/scripts/morris-demo.js"></script>
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
                    <li class="selected">
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
                    <h1 class="page-header">Nilai</h1>
                </div>
                 <!-- end page header-->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <h3>Nilai Akhir : 
                            <?php
                                include 'database.php';
                                $sql = "select nilai, indeks from Nilai where id_mhs = '" . $_SESSION['id_mhs'] . "';";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                if (! $result) {
                                    echo "- <br><small>(Akan muncul setelah 10 Assignment)</small>";    
                                } else{
                                    echo $result['nilai'] . "(" . $result['indeks'] . ")";
                                }
                            ?>
                            </h3>
                            <div id="grafik-nilai"></div>
                            <script>
                                Morris.Bar({
                                    element: 'grafik-nilai',
                                    data: [
                                    <?php
                                        include 'database.php';
                                        $sql = "select nilai, type, tanggal from Assignment where id_mhs = '" . $_SESSION['id_mhs'] . "' order by type DESC;";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "{y: '" . $result['type'] . " " . $result['tanggal'] . "', a: " . $result['nilai'] . "},";
                                        }
                                    ?>
                                    // {y: '2006', a: 100}, {y: '2007', a: 75}, {y: '2008', a: 50}, {y: '2009', a: 75}, {y: '2010', a: 50}, {y: '2011', a: 75}, {y: '2012', a: 100}
                                    ],
                                    xkey: 'y',
                                    ykeys: ['a'],
                                    labels: ['Nilai'],
                                    hideHover: 'auto',
                                    resize: true
                                }); 
                            </script>
                        </div>
                    </div>
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
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/scripts/morris-demo.js"></script>
</body>

</html>
