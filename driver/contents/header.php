<div class="header">
    <a href=""><img src="assets/images/logo linear.svg" width="150"></a>
    <div class="profile">
        <img src="assets/images/man.png" class="rounded-circle dropdown-toggle" width="40" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal">Settings</a></li>
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