<!doctype html>
<html lang="en">

<head>
    <title>AmbuTrack</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("contents/style.php"); ?>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style>

    </style>
</head>

<body>

    <div class="main">
        <?php include("contents/header.php"); ?>
        <div id="map"></div>
        <?php include("contents/footer.php"); ?>
    </div>

    <div class="modal fade" id="noDriverModal" tabindex="-1" aria-labelledby="noDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="d-flex justify-content-center text-center flex-wrap">
                        <img src="assets/images/sorry.png" class="img-fluid" width="150">
                        <div>
                            <h3 class="fw-bold mb-0 mt-3 text-danger">No Driver Found!</h3>
                            <p class="mb-0">Unfortunately, there is no drivers to allocate! All are busy</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("contents/scripts.php"); ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCICKA-61BmahcBSZBx-w99vu-kMaZyepg&callback=initMap&v=weekly&libraries=places" defer></script>
    <script>
        $(".header").addClass("fixed-top");

        let map;
        var ambulances = [];
        let current_lat = "";
        let current_long = "";
        var locationName = "";
        var directionsService;
        var directionsDisplay;
        var isOngoing = false;

        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    current_lat = position.coords.latitude;
                    current_long = position.coords.longitude;

                    // var geocodingAPI = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${current_lat},${current_long}&key=AIzaSyCICKA-61BmahcBSZBx-w99vu-kMaZyepg`;

                    // fetch(geocodingAPI)
                    //     .then(response => response.json())
                    //     .then(data => {
                    //         locationName = data.results[0].formatted_address;
                    //     })
                    //     .catch(error => console.log("Error fetching location data: " + error));

                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 16,
                        center: pos,
                        mapTypeControl: false,
                    });

                    const image = "assets/images/amb.png";
                    const ourimage = "assets/images/loca.png";

                    const ourmarker = new google.maps.Marker({
                        position: pos,
                        map,
                        icon: ourimage,
                    });

                    <?php

                    $sl = 0;
                    $sql = "select * from tbl_drivers where status='Ready'";
                    $run = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_array($run)) {

                        $sl++;
                        $id = $row["id"];
                        $name = $row["name"];
                        $phone = $row["phone"];
                        $latitude = $row["latitude"];
                        $longitude = $row["longitude"];

                    ?>

                        ambulances.push({
                            lat: <?php echo $latitude ?>,
                            lng: <?php echo $longitude ?>,
                            id: <?php echo $id ?>
                        });


                        const marker<?php echo $sl ?> = new google.maps.Marker({
                            position: {
                                lat: <?php echo $latitude ?>,
                                lng: <?php echo $longitude ?>
                            },
                            map,
                            icon: image,
                            title: "<?php echo $name ?>\n<?php echo $phone ?>"
                        });

                    <?php } ?>

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
                        $(".user_data .driver_name").html(result.driver_name);
                        $(".user_data .driver_phone").html(result.driver_phone);

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
                        $(".footer").addClass("d-none");
                    }
                }
            })
        }, 1000)

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

        var nearestDistance = Infinity;
        var nearestLocation = null;

        function calculateDistances() {
            nearestDistance = Infinity;
            nearestLocation = null;
            ambulances.forEach(function(location) {
                const distance = google.maps.geometry.spherical.computeDistanceBetween(
                    new google.maps.LatLng(current_lat, current_long),
                    new google.maps.LatLng(location.lat, location.lng)
                );

                if (distance < nearestDistance) {
                    nearestDistance = distance;
                    nearestLocation = location;
                }
            });
        }

        $(".emergency-btn").click(function() {
            $(".btn-content").addClass("d-none");
            $(".emergency-btn .loader").removeClass("d-none");

            if (ambulances.length != 0) {
                calculateDistances();

                var timer = 10;

                $.ajax({
                    url: "functions/functions.php",
                    type: "POST",
                    data: {
                        send_emergency: true,
                        latitude: current_lat,
                        longitude: current_long,
                        location: locationName,
                        driver: nearestLocation.id,
                        timeout: timer,
                        status: "Waiting",
                    },
                    success: function(result) {
                        if (result == "no_found") {
                            $("#noDriverModal").modal('toggle');
                        } else {
                            if (result == 1 || result == 2) {
                                var intrerval = setInterval(function() {
                                    if (timer == 0) {
                                        timer = 10;
                                        removeObjectById(nearestLocation.id);
                                        resendReq();
                                    } else {
                                        if (ambulances.length != 0) {
                                            $.ajax({
                                                url: "functions/functions.php",
                                                type: "POST",
                                                data: {
                                                    check_emergency: true,
                                                    timeout: timer,
                                                },
                                                success: function(res) {
                                                    res = $.trim(res);
                                                    console.log(res)
                                                    if (res == "no_found") {
                                                        $("#noDriverModal").modal('toggle');
                                                        $(".btn-content").removeClass("d-none");
                                                        $(".emergency-btn .loader").addClass("d-none");
                                                    } else if (res == 'Accept') {
                                                        clearInterval(intrerval);
                                                        $.ajax({
                                                            url: "functions/functions.php",
                                                            type: "POST",
                                                            data: {
                                                                check_ongoing: true,
                                                            },
                                                            success: function(dat) {
                                                                var data = JSON.parse(dat);

                                                                if (data.status == "success") {

                                                                    $(".user_data").removeClass("d-none");
                                                                    $(".user_data .driver_name").html(data.driver_name);
                                                                    $(".user_data .driver_phone").html(data.driver_phone);

                                                                    var start = {
                                                                        lat: current_lat,
                                                                        lng: current_long
                                                                    };
                                                                    var end = {
                                                                        lat: parseFloat(data.lat),
                                                                        lng: parseFloat(data.long)
                                                                    };

                                                                    isOngoing = true;
                                                                    calculateAndDisplayRoute(start, end);
                                                                    $(".footer").addClass("d-none");
                                                                }
                                                            }
                                                        })

                                                    } else if (res == "Reject") {
                                                        console.log("11111")
                                                        removeObjectById(nearestLocation.id);
                                                        resendReq();
                                                    }
                                                }
                                            });
                                            timer--;
                                        } else {
                                            clearInterval(intrerval);
                                            $("#noDriverModal").modal('toggle');
                                            $(".btn-content").removeClass("d-none");
                                            $(".emergency-btn .loader").addClass("d-none");
                                            resetEmergency();
                                        }
                                    }
                                }, 1000);
                            }

                            if (result == 1) {

                                Toastify({
                                    text: "Ambulance allocated, waiting for the response!",
                                    duration: 3000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    style: {
                                        background: "#047855",
                                    },
                                    onClick: function() {}
                                }).showToast();
                            } else if (result == 2) {
                                Toastify({
                                    text: "Ambulance already allocated, please wait for response!",
                                    duration: 3000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    style: {
                                        background: "#D3530C",
                                    },
                                    onClick: function() {}
                                }).showToast();
                            }
                        }
                    }
                })
            } else {
                $("#noDriverModal").modal('toggle');
                $(".btn-content").removeClass("d-none");
                $(".emergency-btn .loader").addClass("d-none");
                resetEmergency();
            }
        })

        function resendReq() {
            calculateDistances();
            if (ambulances.length != 0) {
                $.ajax({
                    url: "functions/functions.php",
                    type: "POST",
                    data: {
                        resend_emergency: true,
                        latitude: current_lat,
                        longitude: current_long,
                        location: locationName,
                        driver: nearestLocation.id,
                        status: "Waiting",
                    },
                    success: function(result) {
                        if (result == "no_found") {
                            $("#noDriverModal").modal('toggle');
                            $(".btn-content").removeClass("d-none");
                            $(".emergency-btn .loader").addClass("d-none");
                            resetEmergency();
                        }
                    }
                })
            } else {
                $("#noDriverModal").modal('toggle');
                $(".btn-content").removeClass("d-none");
                $(".emergency-btn .loader").addClass("d-none");
                resetEmergency();
            }

        }

        function removeObjectById(id) {
            ambulances = ambulances.filter(function(obj) {
                return obj.id !== id;
            });
        }

        function resetEmergency() {
            $.ajax({
                url: "functions/functions.php",
                type: "POST",
                data: {
                    reset_emergency: true,
                },
                success: function(result) {}
            });
        }
    </script>
</body>

</html>