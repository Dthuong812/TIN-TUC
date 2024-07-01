<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BONNIE</title>
    <link rel="stylesheet" href="./static/css/style.css">
    <link rel="stylesheet" href="./static/css/responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        html,
        body,
        #mapCanvas {
            width: 100%;
            height: 500px;
            margin: 0px;
            padding: 0px;
        }

    </style>

<!-- <script src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyDZElPxFYYX3aoGSFxh4_bO7K40e7PsPOY"
        defer></script> -->
    <script>
        var userLatLng; // Đặt biến userLatLng ở phạm vi toàn cục

        function initMap() {
            var map;
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                mapTypeId: 'roadmap'
            };

            // map.setCenter(userLatLng);

            // Display a map on the web page
            map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
            map.setTilt(50);

            // Fix cứng địa chỉ (sẽ fix khi lấy dc data từ sqlserver sau)
            var markers = [
                ['Kho 1 - Lê Văn Lương', 21.004454, 105.804981],
                ['Kho 2 - Sơn Tây', 21.111266, 105.444213],
                ['Kho 3 - Tố Hữu', 20.990047, 105.783319],
                ['Kho 4 - Tây Mỗ', 21.002944, 105.750317]
            ];

            // Info window content 
            var infoWindowContent = [
                ['<div class="info_content">' +
                    '<h2>Kho 1 - Lê Văn Lương</h2>' +
                    '<h3>180 27 Lê Văn Lương,Thanh Xuân, Ha Noi</h3>' +
                    '<p>Noi thu nhan chai nhua va giay. SDT: +84 123 *** 768</p>' +
                    '</div>'],
                ['<div class="info_content">' +
                    '<h2>Kho 2 - Sơn Tây</h2>' +
                    '<h3>423 16, Hữu Nghị ,Xuân Khanh ,Sơn Tât, Ha Noi</h3>' +
                    '<p>Noi thu nhan chai nhua va giay. SDT: +84 345 *** 234</p>' +
                    '</div>'],
                ['<div class="info_content">' +
                    '<h2>Kho 3 - 19 Tô Hữu</h2>' +
                    '<h3>145 19 Tố Hữu ,Nam Từ Liêm, Ha Noi</h3>' +
                    '<p>Noi thu nhan chai nhua va giay. SDT: +84 259 *** 415</p>' +
                    '</div>'],
                ['<div class="info_content">' +
                    '<h2>Kho 4 - Tây Mỗ</h2>' +
                    '<h3>Tây Mỗ,Nam Từ Liêm Ha Noi</h3>' +
                    '<p>Noi thu nhan chai nhua, giay bao. SDT: +84 867 *** 908</p>' +
                    '</div>']
            ];

            // Add multiple markers to map
            var infoWindow = new google.maps.InfoWindow(), marker, i;

            // Place each marker on the map  
            for (i = 0; i < markers.length; i++) {
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[i][0]
                });

                // Add info window to marker    
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(map, marker);

                        var start = marker.getPosition();
                        // Lấy vị trí user
                        var end = userLatLng;
                        console.log(start);
                        // console.log(end);
                        calculateAndDisplayRoute(directionsService, start, end);


                    }
                })(marker, i));

                // Center the map to fit all markers on the screen
                map.fitBounds(bounds);
            }

            // Set zoom level
            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
                this.setZoom(14);
                google.maps.event.removeListener(boundsListener);
            });

            // Trong hàm initMap
            navigator.geolocation.getCurrentPosition(function (position) {
                userLatLng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude

                };
                var customMarkerImage = {
                    url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png', // Đường dẫn đến biểu tượng tùy chỉnh
                    size: new google.maps.Size(32, 32), // Kích thước của biểu tượng (chiều rộng x chiều cao)
                    origin: new google.maps.Point(0, 0), // Điểm gốc của biểu tượng
                    anchor: new google.maps.Point(16, 32) // Điểm neo của biểu tượng (điểm xác định vị trí trên bản đồ)
                };
                var userMarker = new google.maps.Marker({
                    position: userLatLng,
                    map: map,
                    title: 'Your Location',
                    icon: customMarkerImage // Sử dụng biểu tượng tùy chỉnh
                });
               // console.log(userLatLng.lat);
               // console.log(userLatLng.lng);

            });
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);
            directionsRenderer.setDirections(response);

        }
        function calculateAndDisplayRoute(directionsService, start, end) {

            directionsService.route({
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode.DRIVING
            }, function (response, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                } else {
                    window.alert('Không tìm thấy đường đi.');
                }
            });
        }
        window.initMap = initMap;
    </script>
</head>


