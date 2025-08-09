<?php

include("../../admin/assets/includes/db.php");
require('../../functions/smsgatewayhub.php');
session_start();

if (isset($_POST["login"])) {
    $phone = mysqli_escape_string($con, $_POST["phone"]);
    $otp = rand(1000, 9999);
    $message = 'Welcome to Holiday Health Care. Your One Time Password (OTP) is ' . $otp . ' for login. Thank you - HLDYHC';
    $err = sendsms($phone, $message);

    if ($err) {
        echo "Error #:" . $err;
    } else {

        setcookie('driver_otp', $otp);
        $_SESSION['driver_otp'] = true;
        $_SESSION['driver_ref_phone'] = $phone;

        if (isset($_SESSION['driver_otp'])) {
            header("Location: ../");
        }
    }
}

if (isset($_POST['resendotp'])) {
    $phone = $_SESSION['driver_ref_phone'];
    $otp = mt_rand(1000, 9999);
    $message = 'Welcome to Holiday Health Care. Your One Time Password (OTP) is ' . $otp . ' for login. Thank you - HLDYHC';

    $err = sendsms($phone, $message);

    if ($err) {
        echo "<p class='text-center text-danger'>Resend OTP failed!</p>";
    } else {

        setcookie('driver_otp', $otp);
        echo "<p class='text-center text-success'>OTP resend successfully</p>";
    }
}

if (isset($_POST["verify_otp"])) {

    $phone = $_SESSION['driver_ref_phone'];

    $o1 = $_POST["otp1"];
    $o2 = $_POST["otp2"];
    $o3 = $_POST["otp3"];
    $o4 = $_POST["otp4"];

    $entered_otp = $o1 . $o2 . $o3 . $o4;

    if ($entered_otp == $_COOKIE["driver_otp"]) {

        $sql = "select * from tbl_drivers where phone='$phone'";
        if ($result = mysqli_query($con, $sql)) {
            $rowcount = mysqli_num_rows($result);

            if ($rowcount == 0) {
                $insert = "insert into tbl_drivers (phone, name, place, vehicle_no, latitude, longitude, status) values ('$phone', '', '', '', '10.829470515642623', '76.0230518435144', 'Ready')";
                $run = mysqli_query($con, $insert);

                if ($run == true) {
                    $_SESSION['otp-verified'] = true;
                    unset($_SESSION['driver_otp']);
                    unset($_COOKIE['driver_otp']);
                    setcookie('driver_otp', null, -1, '/');
                }
            } else {

                $check_profile = "select * from tbl_drivers where phone='$phone'";
                $run_profile = mysqli_query($con, $check_profile);
                $row_profile = mysqli_fetch_array($run_profile);

                $c_name = $row_profile['name'];
                $c_place = $row_profile['place'];
                $c_vno = $row_profile['vehicle_no'];

                if ($c_name == "" || $c_place == "" || $c_vno == "") {
                    $_SESSION['otp-verified'] = true;
                    unset($_SESSION['driver_otp']);
                    unset($_COOKIE['driver_otp']);
                    setcookie('driver_otp', null, -1, '/');
                } else {
                    unset($_SESSION['driver_otp']);
                    unset($_COOKIE['driver_otp']);
                    setcookie('driver_otp', null, -1, '/');
                    unset($_COOKIE["driver_ref_phone"]);
                    $_SESSION['driver_phone'] = $phone;
                }
            }
        }

        $driver = $_SESSION["driver_phone"];
        $sel_driver = "select * from tbl_drivers where phone='$driver'";
        $run_driver = mysqli_query($con, $sel_driver);
        $row_driver = mysqli_fetch_assoc($run_driver);

        $driver_id = $row_driver["id"];
        $clear_sql = "delete from tbl_situations where driver='$driver_id'";
        $run_clear = mysqli_query($con, $clear_sql);

        header("Location: ../");
    } else {
        header("Location: ../login?error=Entered OTP is incorrect!");
    }
}

if (isset($_POST['save-profile'])) {

    $phone = $_SESSION['driver_ref_phone'];

    $pro_name = $_POST['name'];
    $pro_place = $_POST['place'];
    $pro_vno = $_POST['vno'];

    $usql = "update tbl_drivers set name='$pro_name', place='$pro_place', vehicle_no='$pro_vno' where phone='$phone'";
    $run_update = mysqli_query($con, $usql);

    if ($run_update  == true) {

        $_SESSION['driver_phone'] = $phone;
        unset($_COOKIE["driver_ref_phone"]);
        unset($_SESSION['otp-verified']);
    }
    header("Location: ../");
}

if (isset($_POST['reset'])) {
    unset($_SESSION['driver_otp']);
    unset($_COOKIE['driver_otp']);
    unset($_SESSION['driver_ref_phone']);
    unset($_SESSION['otp-verified']);
    if (!isset($_SESSION['driver_ref_phone'])) {
        header("Location: ../");
    }
}

if (isset($_POST["logout"])) {
    unset($_SESSION['driver_otp']);
    unset($_SESSION['driver_phone']);
    unset($_COOKIE['driver_otp']);
    setcookie('driver_otp', null, -1, '/');
    header("Location: ../");
}

if (isset($_POST["update_location"])) {
    $phone = $_SESSION["driver_phone"];
    $lat = $_POST["latitude"];
    $long = $_POST["longitude"];

    $sql = "update tbl_drivers set latitude='$lat', longitude='$long' where phone='$phone'";
    $run = mysqli_query($con, $sql);
    if ($run == TRUE) {
        echo "Location Updated";
    }
}

if (isset($_POST["confirm_emergency"])) {
    $phone = $_SESSION["driver_phone"];
    $id = $_POST["eid"];
    $status = $_POST["status"];

    if ($status == "Accept") {
        $job_status = "Ongoing";
    } else {
        $job_status = "Reject";
    }

    $sel_eme = "select * from tbl_situations where id='$id'";
    $run_eme = mysqli_query($con, $sel_eme);
    $row_eme = mysqli_fetch_assoc($run_eme);
    $user = $row_eme["phone"];
    $lat = $row_eme["lat"];
    $long = $row_eme["long"];
    $location = $row_eme["location"];

    $ins_sql = "insert into tbl_emergency(driver, phone, latitude, longitude, location, status, sid, job_status) values('$phone', '$user', '$lat', '$long', '$location', '$status', '$id', '$job_status')";
    $ins_run = mysqli_query($con, $ins_sql);

    if ($ins_run == TRUE) {
        $data = array(
            'status' => "success",
            'lat' => $lat,
            'long' => $long,
        );
    } else {
        $data = array(
            'status' => "failed",
        );
    }
    echo json_encode($data);
}

if (isset($_POST["update_status"])) {
    $phone = $_SESSION["driver_phone"];
    $status = $_SESSION["status"];

    $sql = "update tbl_srivers set status='$status' where phone='$phone'";
    $run = mysqli_query($con, $sql);
    if ($run == TRUE) {
        echo "Updated";
    }
}


if (isset($_POST["check_situations"])) {
    $data = array();
    $driver = $_SESSION["driver_phone"];
    $sel_driver = "select * from tbl_drivers where phone='$driver'";
    $run_driver = mysqli_query($con, $sel_driver);
    $row_driver = mysqli_fetch_assoc($run_driver);

    $driver_id = $row_driver["id"];
    $emer_sql = "select * from tbl_situations where driver='$driver_id' AND status='Waiting'";
    $emer_run = mysqli_query($con, $emer_sql);
    while ($emer_row = mysqli_fetch_array($emer_run)) {
        $emer_id = $emer_row["id"];
        $emer_phone = $emer_row["phone"];
        $timeout = $emer_row["timeout"];
        $location = $emer_row["location"];

        $user_sql = "select * from tbl_persons where phone='$emer_phone'";
        $run_user = mysqli_query($con, $user_sql);
        $user_row = mysqli_fetch_assoc($run_user);

        $user_name = $user_row["name"];

        $data[] = array(
            'emergency_id' => $emer_id,
            'user_name' => $user_row["name"],
            'user_phone' => $emer_phone,
            'location' => $location,
            'timeout' => $timeout,
        );
    }

    echo json_encode($data);
}


if (isset($_POST["check_ongoing"])) {
    $driver = $_SESSION["driver_phone"];
    $sel_driver = "select * from tbl_emergency where driver='$driver' AND job_status='Ongoing'";
    $run_driver = mysqli_query($con, $sel_driver);
    $row_driver = mysqli_num_rows($run_driver);

    if ($row_driver == 0) {
        $data = array(
            'status' => "failed",
        );
    } else {
        $row_eme = mysqli_fetch_assoc($run_driver);
        $user = $row_eme['phone'];

        $sel_user = "select * from tbl_persons where phone='$user'";
        $run_sel = mysqli_query($con, $sel_user);
        $row_sel = mysqli_fetch_assoc($run_sel);
        $user_name = $row_sel["name"];

        $data = array(
            'status' => "success",
            'user_name' => $user_name,
            'user_phone' => $user,
        );
    }
    echo json_encode($data);
}
