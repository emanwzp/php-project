<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <link rel="shortcut icon" href="favicon.ico"/>
  <title>Home Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css"/>
</head>

<body>
  <div class="container">
    <div class="main-body">
      <div class="main-container">



        <?php include 'navigation_panel.php'; ?>

        <?php include 'database_functions.php';?>

        <div class = row>
          <div class ="col-md-12">
          <h1 >Testing database data insertion from user input</h1>

          <form method="POST" class="col-md-6">
            <label for="username">Username:</label><br>
            <!--value should be gotten from _POST variable if user had input before-->
            <input type="text" id="username" name="username"  value="<?php if($_SERVER["REQUEST_METHOD"] === "POST"){echo $_POST["username"];}?>" required><br>
            <label for="pword">Password:</label><br>
            <input type="password" id="pword" name="pword" required><br><br>
            <input type="submit" value="Create User"><br>
            <span class="feedback"><?= $feedback;?></span>
          </form>
        </div>


        </div>




        <form method="POST" class="row" action="homepage.php">
          <div class="col-md-8">
            <h1 class='col-md-12'>Testing Database Access in PHP</h1>
            <h3 class="col-md-5">Username</h3>
            <h3 class="col-md-5">Username</h3>
            <?php showDatabase();?>
            <div class="col-md-12">
              <input type="submit" name="clean_table" value="Clean table">
              <input type="submit" name="gen_table" value="Generate table">
              <input type="submit" name="delete_entry" value="Delete Database Entries">
            </div>
          </div>
        </form>


      </div>

    </div>

  </div>

  <?php include 'footer.php'; ?>



</body>
</html>
