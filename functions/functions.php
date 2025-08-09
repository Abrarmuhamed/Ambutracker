<?php

include("../admin/assets/includes/db.php");
require('smsgatewayhub.php');
session_start();

if (isset($_POST["add_home"])) {
    $name = mysqli_escape_string($con, $_POST["name"]);
    $phone = mysqli_escape_string($con, $_POST["phone"]);
    $hname = mysqli_escape_string($con, $_POST["hname"]);
    $place = mysqli_escape_string($con, $_POST["place"]);
    $landmark = mysqli_escape_string($con, $_POST["landmark"]);
    $city = mysqli_escape_string($con, $_POST["city"]);
    $state = mysqli_escape_string($con, $_POST["state"]);
    $district = mysqli_escape_string($con, $_POST["district"]);
    $pincode = mysqli_escape_string($con, $_POST["pincode"]);
    $facilities = mysqli_escape_string($con, $_POST["facilities"]);
    $level = mysqli_escape_string($con, $_POST["level"]);
    $price = mysqli_escape_string($con, $_POST["price"]);
    $latitude = mysqli_escape_string($con, $_POST["latitude"]);
    $longitude = mysqli_escape_string($con, $_POST["longitude"]);

    $img1_name = $_FILES['img1']['name'];
    $img1_TempName = $_FILES['img1']['tmp_name'];
    $file1Destination = "../assets/homes/" . $img1_name;
    move_uploaded_file($img1_TempName, $file1Destination);

    $img2_name = $_FILES['img2']['name'];
    $img2_TempName = $_FILES['img2']['tmp_name'];
    $file2Destination = "../assets/homes/" . $img2_name;
    move_uploaded_file($img2_TempName, $file2Destination);

    $img3_name = $_FILES['img3']['name'];
    $img3_TempName = $_FILES['img3']['tmp_name'];
    $file3Destination = "../assets/homes/" . $img3_name;
    move_uploaded_file($img3_TempName, $file3Destination);

    $proof_name = $_FILES['proof']['name'];
    $proof_TempName = $_FILES['proof']['tmp_name'];
    $file4Destination = "../assets/proofs/" . $proof_name;
    move_uploaded_file($proof_TempName, $file4Destination);

    $sql = "insert into tbl_homes(img1, img2, img3, name, phone, hname, place, landmark, city, district, state, pincode, facilities, proof, level, price, latitude, longitude) values('$img1_name', '$img2_name', '$img3_name', '$name', '$phone', '$hname', '$place', '$landmark', '$city', '$district', '$state', '$pincode', '$facilities', '$proof_name', '$level', '$prices', '$latitude', '$longitude')";
    $run = mysqli_query($con, $sql);
    if ($run == TRUE) {
        header("Location: ../?success=Your home registered successfully");
    } else {
        header("Location: ../?error=Failed to register home!");
    }
}

if (isset($_POST["login"])) {
    $phone = mysqli_escape_string($con, $_POST["phone"]);
    $otp = rand(1000, 9999);
    $message = 'Welcome to Holiday Health Care. Your One Time Password (OTP) is ' . $otp . ' for login. Thank you - HLDYHC';
    $err = sendsms($phone, $message);

    if ($err) {
        echo "Error #:" . $err;
    } else {

        setcookie('ambu_otp', $otp);
        $_SESSION['ambu_otp'] = true;
        $_SESSION['ambu_ref_phone'] = $phone;

        if (isset($_SESSION['ambu_otp'])) {
            header("Location: ../");
        }
    }
}

if (isset($_POST['resendotp'])) {
    $phone = $_SESSION['ambu_ref_phone'];
    $otp = mt_rand(1000, 9999);
    $message = 'Welcome to Holiday Health Care. Your One Time Password (OTP) is ' . $otp . ' for login. Thank you - HLDYHC';

    $err = sendsms($phone, $message);

    if ($err) {
        echo "<p class='text-center text-danger'>Resend OTP failed!</p>";
    } else {

        setcookie('ambu_otp', $otp);
        echo "<p class='text-center text-success'>OTP resend successfully</p>";
    }
}

if (isset($_POST["verify_otp"])) {

    $phone = $_SESSION['ambu_ref_phone'];

    $o1 = $_POST["otp1"];
    $o2 = $_POST["otp2"];
    $o3 = $_POST["otp3"];
    $o4 = $_POST["otp4"];

    $entered_otp = $o1 . $o2 . $o3 . $o4;

    if ($entered_otp == $_COOKIE["ambu_otp"]) {

        $sql = "select * from tbl_persons where phone='$phone'";
        if ($result = mysqli_query($con, $sql)) {
            $rowcount = mysqli_num_rows($result);

            if ($rowcount == 0) {
                $insert = "insert into tbl_persons (phone, name, place) values ('$phone', '', '')";
                $run = mysqli_query($con, $insert);

                if ($run == true) {
                    $_SESSION['otp-verified'] = true;
                    unset($_SESSION['ambu_otp']);
                    unset($_COOKIE['ambu_otp']);
                    setcookie('ambu_otp', null, -1, '/');
                }
            } else {

                $check_profile = "select * from tbl_persons where phone='$phone'";
                $run_profile = mysqli_query($con, $check_profile);
                $row_profile = mysqli_fetch_array($run_profile);

                $c_name = $row_profile['name'];
                $c_place = $row_profile['place'];

                if ($c_name == "" || $c_place == "") {
                    $_SESSION['otp-verified'] = true;
                    unset($_SESSION['ambu_otp']);
                    unset($_COOKIE['ambu_otp']);
                    setcookie('ambu_otp', null, -1, '/');
                } else {
                    unset($_SESSION['ambu_otp']);
                    unset($_COOKIE['ambu_otp']);
                    setcookie('ambu_otp', null, -1, '/');
                    unset($_COOKIE["ambu_ref_phone"]);
                    $_SESSION['ambu_phone'] = $phone;
                }
            }
        }
        header("Location: ../");
    } else {
        header("Location: ../login?error=Entered OTP is incorrect!");
    }
}

if (isset($_POST['save-profile'])) {

    $phone = $_SESSION['ambu_ref_phone'];

    $pro_name = $_POST['name'];
    $pro_place = $_POST['place'];

    $usql = "update tbl_persons set name='$pro_name', place='$pro_place' where phone='$phone'";
    $run_update = mysqli_query($con, $usql);

    if ($run_update  == true) {

        $_SESSION['ambu_phone'] = $phone;
        unset($_COOKIE["ambu_ref_phone"]);
        unset($_SESSION['otp-verified']);
    }
    header("Location: ../");
}

if (isset($_POST['reset'])) {
    unset($_SESSION['ambu_otp']);
    unset($_COOKIE['ambu_otp']);
    unset($_SESSION['ambu_ref_phone']);
    unset($_SESSION['otp-verified']);
    if (!isset($_SESSION['ambu_ref_phone'])) {
        header("Location: ../");
    }
}

if (isset($_POST["logout"])) {
    unset($_SESSION['ambu_otp']);
    unset($_SESSION['ambu_phone']);
    unset($_COOKIE['ambu_otp']);
    setcookie('ambu_otp', null, -1, '/');
    header("Location: ../");
}


if (isset($_POST["send_emergency"])) {
    $driver = $_POST["driver"];
    $status = $_POST["status"];
    $lat = $_POST["latitude"];
    $long = $_POST["longitude"];
    $location = $_POST["location"];
    $timer = $_POST["timeout"];
    $phone = $_SESSION['ambu_phone'];

    $check_free = "select * from tbl_drivers where status='Ready'";
    $run_free = mysqli_query($con, $check_free);
    $count_free = mysqli_num_rows($run_free);

    if ($count_free == 0) {
        $phone = $_SESSION['ambu_phone'];
        $reset_sql = "delete from tbl_situations where phone = '$phone'";
        $run_retest = mysqli_query($con, $reset_sql);
        echo "no_found";
    } else {

        $check_sql = "select * from tbl_situations where phone='$phone' AND status='Waiting'";
        $run_check = mysqli_query($con, $check_sql);
        $row_count = mysqli_num_rows($run_check);

        if ($row_count == 0) {
            $sql = "insert into tbl_situations(phone, location, lat, `long`, status, driver, timeout) values('$phone', '$location', '$lat', '$long', '$status', '$driver', '$timer')";
            $run = mysqli_query($con, $sql);

            if ($run == true) {
                echo 1;
            }
        } else {
            $sql = "update tbl_situations set timeout='$timer' where driver='$driver' AND status='Waiting'";
            $run = mysqli_query($con, $sql);

            echo 2;
        }
    }
}


if (isset($_POST["check_emergency"])) {
    $phone = $_SESSION['ambu_phone'];
    $timer = $_POST['timeout'];

    $check_free = "select * from tbl_drivers where status='Ready'";
    $run_free = mysqli_query($con, $check_free);
    $count_free = mysqli_num_rows($run_free);

    if ($count_free == 0) {
        $phone = $_SESSION['ambu_phone'];
        $reset_sql = "delete from tbl_situations where phone = '$phone'";
        $run_retest = mysqli_query($con, $reset_sql);
        echo "no_found";
    } else {
        $check_sql = "select * from tbl_situations where phone='$phone'";
        $run_check = mysqli_query($con, $check_sql);
        $row_count = mysqli_num_rows($run_check);

        if ($row_count != 0) {
            $row = mysqli_fetch_assoc($run_check);
            $status = $row["status"];
            $sid = $row["id"];

            $sel_status = "select * from tbl_emergency where phone='$phone' AND sid='$sid'";
            $run_status = mysqli_query($con, $sel_status);
            $count_status = mysqli_num_rows($run_status);

            if ($count_status != 0) {
                $status_row = mysqli_fetch_assoc($run_status);
                $status = $status_row['status'];
                $sql = "delete from tbl_situations where id='$sid'";
                $run = mysqli_query($con, $sql);
                echo $status;
            } else {
                $sql = "update tbl_situations set timeout='$timer' where phone='$phone' AND status='Waiting'";
                $run = mysqli_query($con, $sql);
                echo $status;
            }
        }
    }
}

if (isset($_POST["resend_emergency"])) {

    $check_free = "select * from tbl_drivers where status='ready'";
    $run_free = mysqli_query($con, $check_free);
    $count_free = mysqli_num_rows($run_free);

    if ($count_free == 0) {
        $phone = $_SESSION['ambu_phone'];
        $reset_sql = "delete from tbl_situations where phone = '$phone'";
        $run_retest = mysqli_query($con, $reset_sql);
        echo "no_found";
    } else {

        $driver = $_POST["driver"];
        $status = $_POST["status"];
        $lat = $_POST["latitude"];
        $long = $_POST["longitude"];
        $location = $_POST["location"];
        $phone = $_SESSION['ambu_phone'];

        $check_sql = "select * from tbl_situations where phone='$phone' AND status='Waiting'";
        $run_check = mysqli_query($con, $check_sql);
        $row_count = mysqli_num_rows($run_check);

        if ($row_count == 0) {
            $sql = "insert into tbl_situations(phone, location, lat, `long`, status, driver) values('$phone', '$location', '$lat', '$long', '$status', '$driver')";
            $run = mysqli_query($con, $sql);

            if ($run == true) {
                echo 1;
            }
        } else {
            $sql = "update tbl_situations set location='$location', lat='$lat', `long`='$long', status='$status', driver='$driver' where phone='$phone' AND status='Waiting'";
            $run = mysqli_query($con, $sql);

            if ($run == true) {
                echo 1;
            }
        }
        echo $driver;
    }
}

if (isset($_POST["reset_emergency"])) {
    $phone = $_SESSION['ambu_phone'];
    $reset_sql = "delete from tbl_situations where phone = '$phone'";
    $run_retest = mysqli_query($con, $reset_sql);
}

if (isset($_POST["check_ongoing"])) {
    $phone = $_SESSION["ambu_phone"];
    $sel_driver = "select * from tbl_emergency where phone='$phone' AND job_status='Ongoing'";
    $run_driver = mysqli_query($con, $sel_driver);
    $row_driver = mysqli_num_rows($run_driver);

    if ($row_driver == 0) {
        $data = array(
            'status' => "failed",
        );
    } else {
        $row_eme = mysqli_fetch_assoc($run_driver);
        $driver = $row_eme['driver'];

        $sel_driver = "select * from tbl_drivers where phone='$driver'";
        $run_sel = mysqli_query($con, $sel_driver);
        $row_sel = mysqli_fetch_assoc($run_sel);

        $driver_lat = $row_sel["latitude"];
        $driver_long = $row_sel["longitude"];
        $driver_name = $row_sel["name"];

        $data = array(
            'status' => "success",
            'lat' => $driver_lat,
            'long' => $driver_long,
            'driver_name' => $driver_name,
            'driver_phone' => $driver,
        );
    }
    echo json_encode($data);
}
