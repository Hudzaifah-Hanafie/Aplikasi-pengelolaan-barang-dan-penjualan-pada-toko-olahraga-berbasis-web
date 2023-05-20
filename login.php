<?php
require 'function.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //cek akun yang diinput dengan database
    $cekAkun = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");

    $hitungJmlData = mysqli_num_rows($cekAkun);

    if ($hitungJmlData > 0) {
        $_SESSION['login'] = 'True';
        header('location:index.php');
    } else {
        $error = true;
    }
}

if (!isset($_SESSION['login'])) {
    
} else {
    header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Halaman Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <style>
            .uniquebg {
                background-image: url('images/login_bg3.jpg');
                background-repeat: no-repeat;
                background-size: 100% 100%;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div class="uniquebg">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <?php if ( isset($error) ) : ?>
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                Username atau Password yang dimasukkan belum benar.
                                            </div>
                                        <?php endif; ?>
                                        <form method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputUsername">Username</label>
                                                <input class="form-control py-4" name="username" id="inputUsername" type="text" placeholder="Enter username" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        </div>
    </body>
</html>
