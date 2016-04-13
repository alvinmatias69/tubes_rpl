<!DOCTYPE html>
<html>

<head>
	<?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            include 'database.php';
            $data = array(
                'id_admin' => htmlspecialchars($_POST['id_admin']), 
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
        }
    ?>

  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPL E-Learning | Login Admin</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/main-style.css" rel="stylesheet" type="text/css" />
</head>

<body class="body-Login-back">

    <div class="container">
       
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
              <!-- <img src="assets/img/logo.png" alt=""/> -->
            </div>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="ID Admin" name="id_admin" required type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" required type="password" value="">
                                </div>
                                <input type="submit" class="btn btn-lg btn-block btn-success" value="Login"><br>
                                <!-- <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
                                <!-- Change this to a button or input when using this as a form -->
                                <!-- <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a> -->
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
