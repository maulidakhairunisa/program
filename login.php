<?php
session_start();
include('config/config.php');

//cek jika tombol login ditekan
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username ='$username' AND password= '$password'");
    $row = mysqli_fetch_array($query);

    if (is_array($row)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
    } else {
        echo '<script type= "text/javascript">';
        echo 'alert("Username atau Password Salah!")';
        echo 'window.location.href ="login.php"';
        echo '</scipt>';
    }
}
if (isset($_SESSION['username'])) {
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <script src="https://kit.fontawesome.com/02beb43f6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script type="text/javascript" src="assets/js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<style>
    body {
        background-color: #E6E6FA;
    }
</style>

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="assets/img/apotek.png" class="img-fluid" alt="Phone image">
                    <h1 class="text-center mt-5">Apotek Grajakan</h1>
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <div class="card border-dark mb-3" style="max-width: 100vw;">
                        <div class="card-header">
                            <h4 class="text-center">Silahkan Login terlebih dahulu!</h4>
                        </div>
                        <div class="card-body text-dark">
                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger text-center">
                                    <h5>Username / Password Salah</h5>
                                </div>
                            <?php endif; ?>
                            <form action="login.php" method="POST">
                                <!-- Username input -->
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="username" name="username" class="form-control form-control-lg" id="username" placeholder="Masukkan username..." required />
                                </div>
                                <!-- Password input -->
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password..." required />
                                </div>
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="login">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>