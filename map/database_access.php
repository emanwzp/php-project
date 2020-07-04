<?php

// 1. database credentials
$host = "localhost";
$db_name = "project";
$username = "root";
$password = "";

function getConnection(){
  global $host;
  global $db_name;
  global $username;
  global $password;
  $con;
  try {
    // 2. connect to database
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  }
  catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  return $con;
}


function getCountries(){


  $countries = array();
  $visited_countries = array();
  $wishlist_countries = array();

  try {
    // 2. connect to database
    $con = getConnection();
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



function storeCountries($countries, $visited){
  try {
    // 2. connect to database
    $con = getConnection();
    foreach($countries as $country){
      $con = getConnection();
      if($visited){
        $country = filter_var($country, FILTER_SANITIZE_STRING);
        $insert_query = "INSERT INTO countries(name, visited) VALUES (? , ?)";
        $sth = $con->prepare($insert_query);
        $sth->bindParam(1, $country);
        $sth->bindParam(2, $visited);
      }else{
        $insert_query = "INSERT INTO countries(name, visited) VALUES (? , 0)";
        $sth = $con->prepare($insert_query);
        $sth->bindParam(1, $country);
      }

      $sth->execute();
    }
  }
  catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $con = null;
}

  function cleanCountries(){
    $query = "DELETE FROM countries";
    try {
      // 2. connect to database
      $con = getConnection();
      $con->exec($query);
      //echo "<p>Query ran successfully </p>";
    }

    catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
    $con = null;
  }



if($_SERVER["REQUEST_METHOD"] === "POST"){
  cleanCountries();
  if(array_key_exists('visited_countries', $_POST)){
    storeCountries($_POST['visited_countries'], 1);
  }
  if(array_key_exists('wishlist_countries', $_POST)){
    storeCountries($_POST['wishlist_countries'], 0);
  }

  //header('Location: map_page.php');
  //exit;
}



 ?>
