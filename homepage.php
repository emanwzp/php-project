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



        <?php include 'page_components/navigation_panel.php'; ?>

        <?php include 'page_components/database_functions.php';?>

        <div class ="row">

          <h1>Testing database data insertion from user input</h1>
        </div>

        <div class="row">
          <?php function getPreviousInput(){
            if($_SERVER["REQUEST_METHOD"] === "POST" && array_key_exists('username', $_POST)){
              echo $_POST["username"];
            }else{
              return "";
            }
          }?>
          <form method="POST" class="col-md-6">
            <label for="username">Username:</label><br>
            <!--value should be gotten from _POST variable if user had input before-->
            <input type="text" id="username" name="username"  value="<?php getPreviousInput() ?>" required><br>
            <label for="pword">Password:</label><br>
            <input type="password" id="pword" name="pword" required><br><br>
            <input type="submit" value="Create User"><br>
            <span class="feedback"><?= $feedback;?></span>
          </form>
        </div>





        <form method="POST" class="row" action="homepage.php">
          <div class="col-md-8">
            <div class="row">
              <h1>Testing Database Access in PHP</h1>
            </div>
            <div class="row">
              <h3 class="col-sm-5 col-md-5">Username</h3>
              <h3 class="col-sm-5 col-md-5">Password</h3>
            </div>
            <div class="row">
              <?php showTable();?>
            </div>
            <div class="row">
              <input type="submit" class="col" name="clean_table" value="Clean Table">
              <input type="submit" class="col" name="gen_table" value="Generate Table">
              <input type="submit" class="col" name="delete_entry" value="Delete Database Entries">
            </div>
          </div>
        </form>


      </div>

    </div>

  </div>

  <?php include 'page_components/footer.php'; ?>



</body>
</html>
