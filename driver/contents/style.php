<?php

session_start();
include("../admin/assets/includes/db.php");
$_SESSION["driver_phone"] = "9072131343";
if (!isset($_SESSION["driver_phone"])) {
    header("Location: login");
}

?>

<link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
<link rel="manifest" href="assets/images/favicon/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/css/style.css">