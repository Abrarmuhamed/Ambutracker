<div class="header">
    <a href=""><img src="assets/images/logo linear.svg" width="150"></a>
    <div class="profile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="d-flex align-items-center">
            <div class="me-2 text-end">
                <?php
                
                $per_phone = $_SESSION["ambu_phone"];
                $user_sql = "select * from tbl_persons where phone='$per_phone'";
                $run_user = mysqli_query($con, $user_sql);
                $row_user = mysqli_fetch_assoc($run_user);

                $per_name = $row_user["name"];
                $per_place = $row_user["place"];

                ?>
                <p class="mb-0 fw-bold lh-header"><?php echo $per_name ?></p>
                <p class="mb-0 fs-12 lh-header"><?php echo $per_place ?></p>
            </div>
            <img src="assets/images/man.png" class="rounded-circle" width="40">
        </div>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">My Profile</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
        </ul>
    </div>
</div>

<?php

if (isset($_GET["success"])) {
    echo "<div class='alert alert-success'>" . $_GET['success'] . "</div>";
}

if (isset($_GET["error"])) {
    echo "<div class='alert alert-danger'>" . $_GET['error'] . "</div>";
}

?>