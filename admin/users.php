<?php
include("assets/includes/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include("assets/css/style.php");
    ?>
    <title>Users</title>
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
                                <h4 class="card-title ms-0 fw-bold mt-3">USERS</h4>
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
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Mail</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "select * from tbl_customers where status='Active' order by id DESC";
                                $run = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($run)) {
                                    $id = $row["cst_id"];
                                    $name = $row["name"];
                                    $phone = $row["phone"];
                                    $mail = $row["mail"];
                                    $status = $row["status"];
                                ?>
                                    <tr>
                                        <td></td>
                                        <td class="fit"><?php echo $id ?></td>
                                        <td><?php echo $name ?></td>
                                        <td><?php echo $phone ?></td>
                                        <td><?php echo $mail ?></td>
                                        <td class="fit"><?php echo $status ?></td>
                                        <td>
                                            <form action="functions/functions.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                                <button type="button" name="edit_ambulance" class="btn btn-primary" onclick="updateService('<?php echo $id ?>', '<?php echo $title ?>')"><i class="bi bi-pencil"></i></button>
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
        changeNav("users-nav");
    </script>
</body>

</html>