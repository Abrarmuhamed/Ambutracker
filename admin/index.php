<?php
include("assets/includes/db.php");
?>
<!doctype html>
<html lang="en">

<head>
    <?php
    include("assets/css/style.php");
    ?>
    <title>Dashboard</title>
</head>

<body>
    <?php include("assets/content/navbar.php") ?>
    <section class="home">
        <div class="text">
            <div class="admin-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="card-title ms-0 fw-bold mt-2">HOME</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-cards mt-3">
                <div class="row">

                    <div class="col-md-6">
                        <div class="row">
                            <?php
                            $cst_sql = "select * from tbl_ambulances";
                            $run_cst = mysqli_query($con, $cst_sql);
                            $cst_count = mysqli_num_rows($run_cst);
                            ?>
                            <div class="col-md-4 mb-3">
                                <div class="card" style="background-color: #fff;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h6 class="card-title fw-bold">Ambulances</h6>
                                                <h4 class="fw-bold text-black" style="color: #000;"><?php echo $cst_count ?></h4>
                                            </div>
                                            <div class="col-lg-4">
                                                <!-- <div class="card-img-bg mt-2">
                                        <img src="images/about.png" alt="" class="img-fluid">
                                    </div> -->
                                            </div>
                                        </div>
                                        <p class="card-text">Total Ambulances</p>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $ser_sql = "select * from tbl_customers";
                            $run_ser = mysqli_query($con, $ser_sql);
                            $ser_count = mysqli_num_rows($run_ser);
                            ?>
                            <div class="col-md-4 mb-3">
                                <div class="card" style="background-color: #fff;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h6 class="card-title fw-bold">Users</h6>
                                                <h4 class="fw-bold text-black" style="color: #000;"><?php echo $ser_count ?></h4>
                                            </div>
                                            <div class="col-lg-4">
                                                <!-- <div class="card-img-bg mt-2">
                                        <img src="images/portfolio (1).png" alt="" class="img-fluid">
                                    </div> -->
                                            </div>
                                        </div>
                                        <p class="card-text">Total Users</p>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $pdt_sql = "select * from tbl_emergency";
                            $run_pdt = mysqli_query($con, $pdt_sql);
                            $pdt_count = mysqli_num_rows($run_pdt);
                            ?>
                            <div class="col-md-4 mb-3">
                                <div class="card" style="background-color: #fff;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h6 class="card-title fw-bold">Emergency Situations</h6>
                                                <h4 class="fw-bold text-black" style="color: #000;"><?php echo $pdt_count ?></h4>
                                            </div>
                                            <div class="col-lg-4">
                                                <!-- <div class="card-img-bg mt-2">
                                        <img src="images/blog (1).png" alt="" class="img-fluid">
                                    </div> -->
                                            </div>
                                        </div>
                                        <p class="card-text">Total Emergency Situations</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <?php include("assets/content/script.php"); ?>
    <script>
        changeNav("home-nav");
    </script>
</body>

</html>