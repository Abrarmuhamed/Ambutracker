<?php
include("assets/includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include("assets/css/style.php");
    ?>

    <title>Add Ambulance</title>
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
                                <h4 class="card-title ms-0 fw-bold mt-2">ADD AMBULANCE</h4>
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

            <div class="card custom-card-2 mt-2">
                <div class="card-body p-4">
                    <form method="post" action="assets/functions/functions.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label" for="image">Image :</label>
                            <input type="file" class="form-control" name="img" id="image">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name">Name : <span class="txet-theme">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter the Name" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="place">Place : <span class="txet-theme">*</span></label>
                                <input type="text" class="form-control" name="place" id="place" placeholder="Enter Driver's Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="mail">Mail : <span class="txet-theme">*</span></label>
                                <input type="email" class="form-control" name="mail" id="mail" placeholder="Enter Driver's Mail" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="phone1">Phone 1 : <span class="txet-theme">*</span></label>
                                <input type="number" class="form-control" name="phone1" id="phone1" placeholder="Enter Driver's Phone 1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone2">Phone 2 :</label>
                                <input type="number" class="form-control" name="phone2" id="phone2" placeholder="Enter Driver's Phone 2">
                            </div>
                        </div>
                        <div class="row mb-3 bg-f5 p-3">
                            <div class="col-md-6">
                                <label class="form-label" for="username">Username : <span class="txet-theme">*</span></label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="password">Password : <span class="txet-theme">*</span></label>
                                <input type="text" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success float-end" name="add_ambulance" style="background-color:#0d4c91;">SUBMIT</button>
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