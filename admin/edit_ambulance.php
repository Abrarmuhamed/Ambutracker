<?php
include("assets/includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include("assets/css/style.php");
    ?>

    <title>Edit Team</title>
</head>

<body>
    <?php include("assets/content/navbar.php") ?>
    <section class="home">
        <div class="text">
            <div class="admin-card mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-11">
                                <h4 class="card-title ms-0 fw-bold mt-2">EDIT TEAM</h4>
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

            <?php
            $id = $_POST["id"];
            $sql = "select * from tbl_team where id='$id'";
            $run = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($run);

            $img = $row["img"];
            $name = $row["name"];
            $designation = $row["designation"];
            $whatsapp = $row["whatsapp"];
            $facebook = $row["facebook"];
            $twitter = $row["twitter"];
            $linkedin = $row["linkedin"];
            $instagram = $row["instagram"];
            ?>

            <div class="card custom-card-2 mt-2">
                <div class="card-body p-4">
                    <form method="post" action="assets/functions/functions.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label" for="image">Image :</label>
                            <input type="file" class="form-control" name="img" id="image">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Name :</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter the Name" value="<?php echo $name ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Designation :</label>
                            <input type="text" class="form-control" name="designation" id="designation" value="<?php echo $designation ?>" placeholder="Enter the Designation" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="whatsapp">Whatsapp :</label>
                            <input type="number" class="form-control" name="whatsapp" id="whatsapp"  value="<?php echo $whatsapp ?>" placeholder="Enter Whatsapp Number">
                        </div>
                        <label class="form-label" for="facebook">Facebook :</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">https://facebook.com/</span>
                            <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $facebook ?>">
                        </div>
                        <label class="form-label" for="instagram">Instagram :</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">https://instagram.com/</span>
                            <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $instagram ?>">
                        </div>
                        <label class="form-label" for="twitter">Twitter :</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">https://twitter.com/</span>
                            <input type="text" class="form-control" id="twitter" name="twitter" value="<?php echo $twitter ?>">
                        </div>
                        <label class="form-label" for="linkedin">Linkedin :</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">https://linkedin.com/</span>
                            <input type="text" class="form-control" id="linkedin" name="linkedin" value="<?php echo $linkedin ?>">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="old_img" value="<?php echo $img ?>">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <button type="submit" class="btn btn-success float-end" name="update_team" style="background-color:#0d4c91;">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include("assets/content/script.php"); ?>
    <script>
        changeNav("teams-nav");
    </script>
</body>

</html>