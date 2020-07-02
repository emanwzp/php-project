<?php

// 1. database credentials
$host = "localhost";
$db_name = "project";
$username = "root";
$password = "";


function getCountries(){
  global $host;
  global $db_name;
  global $username;
  global $password;

  $countries = array();
  $visited_countries = array();
  $wishlist_countries = array();

  try {
    // 2. connect to database
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //preparing and running query
    $query = "SELECT * FROM countries ORDER BY name";
    $stmt = $con->prepare( $query );
    $stmt->execute();

    //showing results
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $country = $row['name'];
      $visited = $row['visited'];

      if($visited == 1){
        array_push($visited_countries, $country);
      }else{
        array_push($wishlist_countries, $country);
      }

    }
    array_push($countries, $visited_countries);
    array_push($countries, $wishlist_countries);
    return $countries;
  }

  catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $con = null;
}



 ?>
