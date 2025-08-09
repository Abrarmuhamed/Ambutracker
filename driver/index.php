<!doctype html>
<html lang="en">

<head>
    <title>AmbuTrack</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("contents/style.php"); ?>
    <style>
        body {
            overflow: hidden;
        }

        .eme {
            overflow: scroll;
            height: 100vh;
        }
    </style>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
</head>

<body>

    <div class="main">
        <?php include("contents/header.php"); ?>
        <div class="row">
            <div class="col-md-9 m-0 p-0">
                <div id="map"></div>
            </div>
            <div class="col-md-3 m-0 shadow pt-100 px-4 eme">
                <p class="fs-15 fw-bold text-theme">Emergency Situation :</p>
                <div class="row align-items-center box user_data bg-danger border-danger text-white">
                    <div class="col-md-2 text-end">
                        <img src="assets/images/emergency-contact.png" class="img-fluid" width="150">
                    </div>
                    <div class="col-md-10">
                        <p class="mb-0">User Name : <span class="fw-bold user_name"></span></p>
                        <p class="mb-0">User Phone : <span class="fw-bold user_phone"></span></p>
                        <div class="divider m-0 my-2"></div>
                        <p class="mb-0" style="font-size: 16px;">Ambulance will arive in : <span class="fw-bold ambulance_time">10 Seconds</span></p>
                    </div>
                </div>
                <div class="row" id="emergency_list">
                </div>
                <div class="divider my-2"></div>
                <p class="fs-15 fw-bold text-theme">Old Emergency Situations :</p>
                <div class="row">
                    <?php
                    $driver = $_SESSION["driver_phone"];
                    $eme_sql = "Select * from tbl_emergency where driver='$driver'";
                    $run_eme = mysqli_query($con, $eme_sql);
                    while ($row_eme = mysqli_fetch_array($run_eme)) {
                        $user_phone = $row_eme["phone"];
                        $location = $row_eme["location"];
                        $status = $row_eme["status"];

                        $user_sql = "select * from tbl_persons where phone='$user_phone'";
                        $run_user = mysqli_query($con, $user_sql);
                        $user_row = mysqli_fetch_assoc($run_user);

                        $user_name = $user_row["name"];
                    ?>
                        <div class="col-md-12 mb-2">
                            <div class="box">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <p class="mb-0 fw-bold"><?php echo $user_name ?></p>
                                        <p class="mb-0"><?php echo $user_phone ?></p>
                                        <p class="mb-0 mt-2">Address:</p>
                                        <p class="mb-0"><?php echo $location ?></p>
                                        <div class="divider m-0 my-2"></div>
                                        <p class="mb-0">Status : <span class="fw-bold <?php if ($status == 'Accept') echo 'text-success';
                                                                                        else echo 'text-danger'; ?>"><?php echo $status ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php include("contents/scripts.php"); ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCICKA-61BmahcBSZBx-w99vu-kMaZyepg&callback=initMap&v=weekly&libraries=places" defer></script>
    <script>
        $(".header").addClass("fixed-top");

        let map;
        let current_lat = "";
        let current_long = "";
        let dest_lat = "";
        let dest_long = "";
        var isOngoing = false;
        var directionsService;
        var directionsDisplay;

        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {

                    const pos = {
                        // lat: position.coords.latitude,
                        // lng: position.coords.longitude,
                        lat: 10.888473,
                        lng: 76.072544
                    };

                    // current_lat = position.coords.latitude;
                    // current_long = position.coords.longitude;
                    current_lat = 10.888473;
                    current_long = 76.072544;

                    var interval = setInterval(function() {
                        $.ajax({
                            url: "functions/functions.php",
                            type: "POST",
                            data: {
                                update_location: true,
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                            },
                            success: function(result) {

                            }
                        })

                        if (isOngoing == false) {
                            $.ajax({
                                url: "functions/functions.php",
                                type: "POST",
                                data: {
                                    check_situations: true,
                                },
                                success: function(result) {
                                    var html = "";
                                    var res = JSON.parse(result);
                                    $.each(res, function(index, item) {

                                        html += '<div class="col-md-12 mb-2">' +
                                            '<div class="box">' +
                                            '    <div class="row align-items-center">' +
                                            '       <div class="col-md-7">' +
                                            '           <p class="mb-0 fw-bold">' + item.user_name + '</p>' +
                                            '           <p class="mb-0">' + item.user_phone + '</p>' +
                                            '            <p class="mb-0 mt-2">Address:</p>' +
                                            '           <p class="mb-0">' + item.location + '</p>' +
                                            '           <div class="divider m-0 my-2"></div>' +
                                            '           <p class="mb-0">Timeout : <span class="fw-bold">' + item.timeout + ' Seconds</span></p>' +
                                            '       </div>' +
                                            '       <div class="col-md-5">' +
                                            '           <div class="d-flex justify-content-end">' +
                                            '               <input type="hidden" name="eid" class="eid" value="' + item.emergency_id + '">' +
                                            '               <button type="button" name="accept_emergency" class="btn btn-sm btn-success me-2 accept-btn">Accept</button>' +
                                            '               <button type="button" name="reject_emergency" class="btn btn-sm btn-theme reject-btn">Reject</button>' +
                                            '           </div>' +
                                            '       </div>' +
                                            '   </div>' +
                                            '</div>' +
                                            '</div>';
                                    });
                                    $("#emergency_list").html(html);
                                }
                            })
                        }

                    }, 1000);

                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 16,
                        center: pos,
                        mapTypeControl: false,
                    });

                    const image = "assets/images/loca.png";
                    const ourimage = "assets/images/amb.png";

                    const ourmarker = new google.maps.Marker({
                        position: pos,
                        map,
                        icon: ourimage,
                    });

                    map.setOptions({
                        styles: styles["hide"]
                    });

                    directionsService = new google.maps.DirectionsService;

                    directionsDisplay = new google.maps.DirectionsRenderer({
                        map: map
                    });

                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        };

        window.initMap = initMap;

        setTimeout(function() {
            $.ajax({
                url: "functions/functions.php",
                type: "POST",
                data: {
                    check_ongoing: true,
                },
                success: function(data) {
                    var result = JSON.parse(data);

                    if (result.status == "success") {
                        $(".user_data").removeClass("d-none");
                        $(".user_data .user_name").html(result.user_name);
                        $(".user_data .user_phone").html(result.user_phone);

                        var start = {
                            lat: current_lat,
                            lng: current_long
                        };
                        var end = {
                            lat: parseFloat(result.lat),
                            lng: parseFloat(result.long)
                        };

                        isOngoing = true;
                        calculateAndDisplayRoute(start, end);
                    }
                }
            })
        }, 1000)

        $("body").on("click", ".accept-btn", function() {
            var eid = $(this).parents(".box").find(".eid").val();
            var lat = $(this).parents(".box").find(".lat").val();
            var long = $(this).parents(".box").find(".long").val();
            var box = $(this).parents(".box");

            $.ajax({
                url: "functions/functions.php",
                type: "POST",
                data: {
                    confirm_emergency: true,
                    eid: eid,
                    status: "Accept",
                },
                success: function(data) {
                    var result = JSON.parse(data);

                    if (result.status == "success") {

                        var start = {
                            lat: current_lat,
                            lng: current_long
                        };

                        var end = {
                            lat: parseFloat(result.lat),
                            lng: parseFloat(result.long)
                        };

                        isOngoing = true;
                        calculateAndDisplayRoute(start, end);
                        box.remove();
                    }
                }
            })
        })

        $("body").on("click", ".reject-btn", function() {
            var eid = $(this).parents(".box").find(".eid").val();
            $.ajax({
                url: "functions/functions.php",
                type: "POST",
                data: {
                    confirm_emergency: true,
                    eid: eid,
                    status: "Reject"
                },
                success: function(result) {
                    if (result == "success") {

                    }
                }
            })
        })

        const styles = {
            default: [],
            hide: [{
                    featureType: "transit",
                    elementType: "labels.icon",
                    stylers: [{
                        visibility: "off"
                    }],
                },
                {
                    featureType: "poi",
                    stylers: [{
                        visibility: "off"
                    }],
                },
            ],
        };

        function calculateAndDisplayRoute(start, end) {
            directionsService.route({
                origin: start,
                destination: end,
                travelMode: 'DRIVING'
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                    var bounds = new google.maps.LatLngBounds();
                    var route = response.routes[0];
                    route.legs.forEach(function(leg) {
                        leg.steps.forEach(function(step) {
                            step.path.forEach(function(path) {
                                bounds.extend(path);
                            });
                        });
                    });
                    if (map) {
                        map.fitBounds(bounds);
                    }
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }
    </script>
</body>

</html>