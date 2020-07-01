<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <link rel="shortcut icon" href="favicon.ico"/>
  <title>Javascript Sandbox</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css"/>
  <script language="javascript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/p5@1.0.0/lib/p5.min.js"></script>
  <!--<script language="javascript" src="https://cdn.jsdelivr.net/npm/p5@1.0.0/lib/addons/p5.sound.min.js"></script> -->
  <script language="javascript" type="text/javascript" src="text_steering/vehicle.js"></script>

</head>

<body>
  <div class="container">
    <div class="main-body">
      <div class="main-container">
          <?php include 'page_components/navigation_panel.php'; ?>
          <!-- find way to align center -->
          <h1>Using javascript with p5.js library</h1>
          <h2>Steering behaviours</h2>

          <div id="canvasContainer" class="row">
            <script language="javascript" type="text/javascript" src="text_steering/steering_canvas.js"></script>
          </div>




      </div>

    </div>

  </div>
</div>

  <?php include 'page_components/footer.php'; ?>



</body>
</html>
