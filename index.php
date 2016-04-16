<!DOCTYPE html>
<html>

<head>
    <?php
        $error = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            include 'database.php';
            if ($_POST['type'] == 'admin') {
                $data = array(
                    'id_admin' => htmlspecialchars($_POST['id']), 
                    'password' => md5(htmlspecialchars($_POST['password']))
                );
                $sql = "select * from Admin where id_admin = '" . $data['id_admin'] . "' and password = '" . $data['password'] . "';";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (! $result) {
                    $error = "ID atau Password salah";
                } else{
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['id_admin'] = $data['id_admin'];
                    echo "<meta http-equiv='refresh' content='0;url=form_mahasiswa.php'>";
                }
            } else if($_POST['type'] == 'dosen'){
                $data = array(
                    'id_dosen' => htmlspecialchars($_POST['id']), 
                    'password' =>md5(htmlspecialchars($_POST['password']))
                );
                $sql = "select * from Dosen where id_dosen = '" . $data['id_dosen'] . "' and password = '" . $data['password'] . "';";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (! $result) {
                    $error = "ID atau password salah";
                } else{
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['id_dosen'] = $data['id_dosen'];
                    echo "<meta http-equiv='refresh' content='0;url=panel_dosen.php'>";
                }
            } else{
                $data = array(
                    'id_mhs'    => htmlspecialchars($_POST['id']), 
                    'password'  => md5(htmlspecialchars($_POST['password']))
                );
                $sql = "select * from Mahasiswa where id_mhs = '" . $data['id_mhs'] . "' and password = '" . $data['password'] . "';";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (! $result) {
                    $error = "ID atau password salah";
                } else {
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['id_mhs'] = $data['id_mhs'];
                    echo "<meta http-equiv='refresh' content='0;url=mhs_nilai.php'>";
            }
            }
            
        }
    ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning || Login</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />

</head>

<body class="body-Login-back">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
              <img src="assets/img/RPLL.png" alt=""/>
            </div>
            <?php
                if($error != ""){
                    $tipe = "alert-danger";
                    $str = "Gagal!";
                    $msg = " ID atau Password salah!";
                    echo '
                    <div class="col-md-4 col-md-offset-4">
                        <div class="alert ' . $tipe . ' fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>' . $str . '</strong>' . $msg . ' 
                        </div>
                    </div> ';
                }
            ?>
            <div class="col-md-4 col-md-offset-4">            
                <div class="login-panel panel panel-default">                                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="id" type="number" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="type">
                                    	<option value="admin">Admin</option>
                                    	<option value="dosen">Dosen</option>
                                    	<option value="mahasiswa">Mahasiswa</option>
                                    </select>
                                </div>
                        
                                <input type="submit" class="btn btn-lg btn-block btn-success" value="Login"><br>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>

</body>

</html>
