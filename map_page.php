<html lang="en">
<head>
  <meta charset="utf-8"/>
  <link rel="shortcut icon" href="favicon.ico"/>
  <title>Scratch Map</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css"/>




    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>

    <script language="javascript" src="map/borders.js"></script>



</head>

<body>

  <div class="container ">
    <div class="main-body">
      <div class="main-container box">

        <?php include 'page_components/navigation_panel.php'; ?>


        <h1>Select Countries you have visited</h1>

        <div id="mapid" class="row">
          <script language="javascript" src="map/map_canvas.js"></script>
        </div>

        <div class="row">
          <p>Click on a country on the map, to add or remove it, or use the text field below</p>
          <input type="text" placeholder="Country Name" id="countryInput">
          <span id="feedback"></span>
        </div>
        <div class="row">
          <button type="button" onclick="addCountry();">Add Country</button>
          <button type="button" onclick="removeCountry();">Remove Country</button>
        </div class="row">






      </div>
    </div>
  </div>
  <?php include 'page_components/footer.php';?>


</body>
