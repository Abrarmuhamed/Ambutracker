<?php
include("assets/includes/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include("assets/css/style.php");
    ?>
    <title>Ambulances</title>
</head>

<body>
    <?php include("assets/content/navbar.php") ?>
    <section class="home">
        <div class="text">
            <div class="admin-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center ">
                            <div class="col-lg-10">
                                <h4 class="card-title ms-0 fw-bold mt-3">AMBULANCES</h4>
                            </div>
                            <div class="col-lg-2 text-end">
                                <a href="add_ambulance.php" class="btn dashboard-btn me-auto" style="background-color: #0d4c91;">Add Ambulance</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (isset($_GET["error"])) {
            ?>
                <div class="alert alert-danger text-center mt-2" role="alert">
                    <?php
                    $error = $_GET["error"];
                    echo $error;
                    ?>
                </div>
            <?php
            } else if (isset($_GET["success"])) {
            ?>
                <div class="alert alert-success text-center mt-2" role="alert">
                    <?php
                    $error = $_GET["success"];
                    echo $error;
                    ?>
                </div>
            <?php } ?>

            <div class="card custom-card-2 mt-3">
                <div class="card-body p-3">
                    <div class="row">

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Ambulance ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Place</th>
                                    <th>Phone</th>
                                    <th>Mail</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $count = 0;
                                $sql = "select * from tbl_ambulances where action='Active' order by id DESC";
                                $run = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($run)) {
                                    $count++;
                                    $id = $row["amb_id"];
                                    $img = $row["driver_img"];
                                    $name = $row["driver_name"];
                                    $place = $row["driver_place"];
                                    $phone = $row["driver_phone_1"];
                                    $mail = $row["driver_mail"];
                                    $username = $row["username"];
                                    $status = $row["status"];
                                    $date = $row["date"];

                                    if($img == ""){
                                        $img = "ambulance.png";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $count ?></td>
                                        <td class="fit"><?php echo $id ?></td>
                                        <td class="fit"><img src="assets/images/ambulances/<?php echo $img ?>" width="30" /></td>
                                        <td><?php echo $name ?></td>
                                        <td><?php echo $place ?></td>
                                        <td><?php echo $phone ?></td>
                                        <td><?php echo $mail ?></td>
                                        <td><?php echo $username ?></td>
                                        <td class="fit"><?php echo $status ?></td>
                                        <td><?php echo $date ?></td>
                                        <td>
                                            <form action="assets/functions/functions.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                                <button type="submit" name="edit_ambulance" class="btn btn-primary" onclick="return confirm('Are you sure to update this item?');"><i class="bi bi-pencil"></i></button>
                                                <button type="submit" name="del_ambulance" class="btn btn-danger" onclick="return confirm('Are you sure to delete this item?');"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include("assets/content/script.php"); ?>
    <script>
        changeNav("ambulance-nav");
    </script>
</body>

</html>