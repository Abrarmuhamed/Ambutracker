<?php
include("../includes/db.php");

session_start();

if (isset($_POST['logout'])) {
  unset($_SESSION['ambulance_loggedin']);
  header("Location:../../login.php");
}

if (isset($_POST["login"])) {
  $username = mysqli_real_escape_string($con, $_POST["username"]);
  $password = mysqli_real_escape_string($con, $_POST["password"]);
  $passhash = hash("sha256", $password);
  $sql = "select * from tbl_users where username='$username' and password='$passhash'";
  $run = mysqli_query($con, $sql);
  $count = mysqli_num_rows($run);
  if ($count === 0) {
    header("Location: ../../login.php?error=Invalid credential");
  } else {
    $_SESSION["ambulance_loggedin"] = true;
    header("Location: ../../index.php");
  }
}

if (isset($_POST["add_ambulance"])) {

  if ($_FILES['img']['size'] === 0) {
    $img = "";
  } else {
    $img = $_FILES["img"]["name"];
    $tmp_name = $_FILES["img"]["tmp_name"];
    $to = "../images/ambulances/" . $img;
    move_uploaded_file($tmp_name, $to);
  }

  $name = mysqli_real_escape_string($con, $_POST["name"]);
  $place = mysqli_real_escape_string($con, $_POST["place"]);
  $mail = mysqli_real_escape_string($con, $_POST["mail"]);
  $phone1 = mysqli_real_escape_string($con, $_POST["phone1"]);
  $phone2 = mysqli_real_escape_string($con, $_POST["phone2"]);
  $username = mysqli_real_escape_string($con, $_POST["username"]);
  $password = mysqli_real_escape_string($con, $_POST["password"]);
  $pass_hash = md5("sha256", $password);

  $nlquery = "SELECT * FROM tbl_ambulances WHERE id=(SELECT MAX(id) FROM tbl_ambulances);";
  $nlrun = mysqli_query($con, $nlquery);
  $nlrow = mysqli_fetch_array($nlrun);
  if ($nlrow["amb_id"] == null) {
    $amb_id = "AMB-001";
  } else {
    $lastcid = $nlrow["amb_id"];
    $lastcid_no = (int)str_replace("AMB-", "", $lastcid) + 1;
    $digitlen = strlen((string)$lastcid_no);

    if ($digitlen < 3) {
      $digbl = 3 - (int)$digitlen;
      $zero = str_repeat("0", $digbl);
      $amb_id = "AMB-" . $zero . (string)$lastcid_no;
    } else {
      $amb_id = "AMB-" . (string)$lastcid_no;
    }
  }

  $sql = "insert into tbl_ambulances(amb_id, driver_img, driver_name, driver_place, driver_phone_1, driver_phone_2, driver_mail, username, password, status, action) values('$amb_id', '$img', '$name', '$place', '$phone1', '$phone2', '$mail', '$username', '$pass_hash', 'Active', 'Active')";
  $run = mysqli_query($con, $sql);
  if ($run === TRUE) {
    header("Location: ../../ambulances?success=Ambualnce Added Successfully");
  } else {
    header("Location: ../../ambulances?error=Failed to Add Ambulance!");
  }
}

if (isset($_POST["del_ambulance"])) {
  $id = $_POST["id"];
  $sql = "update tbl_ambulances set action='Removed' where amb_id='$id'";
  $run = mysqli_query($con, $sql);
  if ($run === TRUE) {
    header("Location: ../../ambulances?success=Ambulance Deleted Successfully");
  } else {
    header("Location: ../../ambulances?error=Failed to Delete Ambulance!");
  }
}

if (isset($_POST["update_ambulance"])) {
  $id = $_POST["id"];
  $img = "";
  if ($_FILES['img']['size'] === 0) {
    $img = $_POST["old_img"];
  } else {
    $img = $_FILES["img"]["name"];
    $tmp_name = $_FILES["img"]["tmp_name"];
    $to = "../../assets/images/customers/" . $img;
    move_uploaded_file($tmp_name, $to);
  }
  $sql = "update tbl_customers set img='$img' where id='$id'";
  $run = mysqli_query($con, $sql);
  if ($run === TRUE) {
    header("Location: ../../customer.php?success=Customer Edited Successfully");
  } else {
    header("Location: ../../customer.php?error=Failes To edit Customer!");
  }
}
