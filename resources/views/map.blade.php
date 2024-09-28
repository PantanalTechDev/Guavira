<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #1d2634;
            color: #9e9ea4;
            font-family: 'Montserrat', sans-serif;
        }

        .material-icons-outlined {
            vertical-align: middle;
            line-height: 1px;
            font-size: 35px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 260px 1fr 1fr 1fr;
            grid-template-rows: 0.2fr 3fr;
            grid-template-areas:
                'sidebar header header header'
                'sidebar main main main';
            height: 100vh;
        }

        /* ---------- HEADER ---------- */
        .header {
            grid-area: header;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 6px 7px -3px rgba(0, 0, 0, 0.35);
        }

        .menu-icon {
            display: none;
        }

        /* ---------- SIDEBAR ---------- */
        #sidebar {
            grid-area: sidebar;
            height: 100%;
            background-color: #263043;
            overflow-y: auto;
            transition: all 0.5s;
        }

        .sidebar-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px;
            margin-bottom: 30px;
        }

        .sidebar-title > span {
            display: none;
        }

        .sidebar-brand {
            font-size: 20px;
            font-weight: 700;
        }

        .sidebar-list {
            padding: 0;
            list-style-type: none;
        }

        .sidebar-list-item {
            padding: 20px;
            font-size: 18px;
        }

        .sidebar-list-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .sidebar-list-item > a {
            text-decoration: none;
            color: #9e9ea4;
        }

        .sidebar-responsive {
            display: inline !important;
            position: absolute;
            z-index: 12 !important;
        }

        /* ---------- MAIN ---------- */
        .main-container {
            grid-area: main;
            overflow-y: auto;
            padding: 20px;
            color: rgba(255, 255, 255, 0.95);
        }

        .main-title {
            display: flex;
            justify-content: space-between;
        }

        .main-cards {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            padding: 25px;
            border-radius: 5px;
        }

        .card:first-child {
            background-color: #2962ff;
        }

        .card:nth-child(2) {
            background-color: #ff6d00;
        }

        .card:nth-child(3) {
            background-color: #2e7d32;
        }

        .card:nth-child(4) {
            background-color: #d50000;
        }

        .card-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-inner > .material-icons-outlined {
            font-size: 45px;
        }

        .map-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            height: 700px; /* 400 (original) Set height for the map container */
        }

        #map {
            height: 50%;
            width: 40%;
        }

        /* ---------- MEDIA QUERIES ---------- */
        @media screen and (max-width: 992px) {
            .grid-container {
                grid-template-columns: 1fr;
                grid-template-rows: 0.2fr 3fr;
                grid-template-areas:
                    'header'
                    'main';
            }

            #sidebar {
                display: none;
            }

            .menu-icon {
                display: inline;
            }

            .sidebar-title > span {
                display: inline;
            }
        }

        @media screen and (max-width: 768px) {
            .main-cards {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .map-container {
                margin-top: 30px;
            }
        }

        @media screen and (max-width: 576px) {
            .header-left {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="grid-container">

        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>
            <div class="header-left">
                <span class="material-icons-outlined">search</span>
            </div>
            <div class="header-right">
                <span class="material-icons-outlined">notifications</span>
                <span class="material-icons-outlined">email</span>
                <span class="material-icons-outlined">account_circle</span>
            </div>
        </header>
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined">shopping_cart</span> STORE
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>
        </aside>
        <main class="main-container">
            <div class="main-title">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Map now positioned directly below the title -->
            <div class="map-container">
                <div id="map"></div>
            </div>
        </main>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7WqvFFtkFCYHsncBNNOf4R4R6NpQOmco"></script>
    <script>
        // Initialize the map
        var map = new google.maps.Map(document.getElementById('map'), {
          center: { lat: -20.459110289527487, lng: -54.6540373110798 },
          zoom: 12
        });
      
        // Get Guavira data passed from the backend
        var guaviras = @json($guaviras);
      
        // Handle the case where there are no Guaviras
        if (guaviras === null) {
          console.log("No Guaviras found.");
          // Optionally, display a message to the user
          document.getElementById('map').innerHTML = '<p>There are currently no Guaviras registered.</p>';
        } else {
          // Process the Guavira data as before
          guaviras.forEach(function(guavira) {
            var marker = new google.maps.Marker({
              position: { lat: parseFloat(guavira.latitude), lng: parseFloat(guavira.longitude) },
              map: map,
              title: guavira.descricao
            });
      
            // Add an info window for each marker
            var infowindow = new google.maps.InfoWindow({
              content: `
                <div style="color: black; font-size: 14px">
                  <strong>Owner:</strong> ${guavira.owner}<br>
                  <strong>Description:</strong> ${guavira.descricao}<br>
                  <img src="${guavira.imagem}" alt="Tree Image" style="width:100px;">
                </div>
              `
            });
      
            // Add a click listener to show the info window when a marker is clicked
            marker.addListener('click', function() {
              infowindow.open(map, marker);
            });
          });
        }
      
        function openSidebar() {
          document.getElementById('sidebar').style.transform = 'translateX(0)';
        }
      
        function closeSidebar() {
          document.getElementById('sidebar').style.transform = 'translateX(-100%)';
        }
      </script>
</body>
</html>
