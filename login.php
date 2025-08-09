<?php

session_start();
$_SESSION["ambu_phone"] = "9995466747";
include("admin/assets/includes/db.php");

if (isset($_SESSION["ambu_phone"])) {
    header("Location: /");
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - AmbuTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/loginstyle.css">
</head>

<body>

    <section id="sign-up">
        <div class="row h-100vh justify-content-center align-items-center m-0" id="sign-up-card">
            <div class="col-md-4">
                <div class="sign-content">
                    <?php

                    if (isset($_GET["success"])) {
                        echo "<div class='alert alert-success'>" . $_GET['success'] . "</div>";
                    }

                    if (isset($_GET["error"])) {
                        echo "<div class='alert alert-danger'>" . $_GET['error'] . "</div>";
                    }

                    ?>
                    <?php if (!isset($_SESSION["ambu_otp"]) && !isset($_SESSION["otp-verified"])) { ?>
                        <div id="number-div">
                            <img src="assets/images/logo linear.svg" class="img-fluid mb-3" width="225">
                            <h5 class="text-theme fw-bold mb-0 mt-3">Welcome Again!</h5>
                            <p class="text-theme-2 fs-12 mt-1">Call nearest ambulance on emergency situations!
                            </p>
                            <div class="divider"></div>
                            <form action="functions/functions.php" method="post" class="mt-3">
                                <div class="mb-1 text-start">
                                    <div class="input-group mb-1">
                                        <span class="input-group-text fs-12 border-none br-0" id="pn"><img src="assets/images/india.png" class="me-2" width="25"> +91</span>
                                        <input type="text" class="form-control fs-12" id="phone" name="phone" placeholder="Enter Your Phone Number" aria-label="Phone Number" aria-describedby="pn" required>
                                    </div>
                                </div>
                                <button type="submit" name="login" class="btn btn-theme btn-sm fs-13 br-0 fw-bold mt-1 py-2 w-100">Login</button>
                            </form>
                        </div>
                    <?php
                    }
                    if (isset($_SESSION["ambu_otp"])) {
                    ?>
                        <div id="otp-div">
                            <img src="assets/images/security.svg" class="img-fluid mb-3" width="200">
                            <h5 class="fw-bold mb-0">Enter Your <span class="text-theme">Verification Code</span></h5>
                            <p class="text-theme-2 fs-12 mt-1 mb-1">We have sent an OTP to <span class="text-theme">+91 <?php echo $_SESSION['ambu_ref_phone']; ?></span>
                            </p>
                            <form action="functions/functions.php" method="post">
                                <button type="submit" name="reset" class="fs-12 btn-none">Change Number?</button>
                            </form>
                            <div class="divider mt-2 mb-2"></div>
                            <form action="functions/functions.php" method="post">
                                <div class="otp-input-fields">
                                    <input type="number" name="otp1" class="otp__digit otp__field__1" required>
                                    <input type="number" name="otp2" class="otp__digit otp__field__2" required>
                                    <input type="number" name="otp3" class="otp__digit otp__field__3" required>
                                    <input type="number" name="otp4" class="otp__digit otp__field__4" required>
                                </div>
                                <div id="resend-div" class="my-3 fs-12"></div>
                                <button type="submit" name="verify_otp" class="btn btn-theme btn-sm fs-13 br-0 fw-bold mt-1 py-2 px-5 mt-2">Login</button>
                            </form>
                        </div>
                    <?php }
                    if (isset($_SESSION["otp-verified"])) {
                    ?>
                        <div id="otp-div">
                            <img src="assets/images/security.svg" class="img-fluid mb-3" width="200">
                            <h5 class="fw-bold mb-0">Enter Your <span class="text-theme">Details</span></h5>
                            <p class="text-theme-2 fs-12 mt-1 mb-1">Please fill below form!</span>
                            </p>
                            <div class="divider mt-2 mb-4"></div>
                            <form action="functions/functions.php" method="post">
                                <div class="mb-3 text-start">
                                    <label for="name">Name :</label>
                                    <input type="text" class="form-control fs-12" id="name" name="name" placeholder="Enter Your Name" aria-label="Name" required>
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="place">Place :</label>
                                    <input type="text" class="form-control fs-12" id="place" name="place" placeholder="Enter Your Place" aria-label="Place" required>
                                </div>
                                <button type="submit" name="save-profile" class="btn btn-theme btn-sm fs-13 br-0 fw-bold mt-1 py-2 px-5 mt-2">Save Profile</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>

    <?php
    if (isset($_SESSION['ambu_otp'])) {
    ?>
        <script>
            var timeLeft = 30;
            var elem = document.getElementById("resend-div");
            var timerId = setInterval(countdown, 1000);

            function countdown() {
                if (timeLeft == -1) {
                    clearTimeout(timerId);
                    elem.innerHTML = '<a href="#" id="resend-otp" class="fs-12 fw-bold">Resend OTP</a>';
                } else {
                    elem.innerHTML = "Resend OTP after " + timeLeft + " seconds";
                    timeLeft--;
                }
            }
        </script>
    <?php } ?>
</body>

</html>