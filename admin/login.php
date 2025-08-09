<?php
include("assets/includes/db.php");
?>
<!doctype html>
<html lang="en">

<head>
    <?php
    session_start();
    if (isset($_SESSION["ambulance_loggedin"])) {
        header("Location: index.php");
    }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="images/title image.jpg">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="../assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>Login - AmbuTrack</title>
</head>

<body>
    <section class="login-page">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 login-bg">
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <form method="POST" class="w-75" action="assets/functions/functions.php">
                        <h4>Admin Login</h4>
                        <p>Hey, enter your credential to sign in to your account</p>
                        <?php
                        if (isset($_GET["error"])) {
                        ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?php
                                $error = $_GET["error"];
                                echo strip_tags($error);
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="mb-3">
                            <i class="bi bi-lock"></i>
                            <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter username" required>
                        </div>
                        <div class="mb-3">
                            <i class="bi bi-key"></i>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="text-center">
                            <input type="submit" name="login" value="LOGIN" class="btn w-100 login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>