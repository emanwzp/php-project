<?php

// 1. database credentials
$host = "localhost";
$db_name = "project";
$username = "root";
$password = "";


$feedback =  "";

//handles button presses and data input from forms
//if there was a form submission, add data from form into database
if($_SERVER["REQUEST_METHOD"] === "POST"){
  if(array_key_exists('clean_table', $_POST)){
    $query = "DELETE FROM users";
    runQuery($query);
  }elseif(array_key_exists('gen_table', $_POST)){
    generateDBTable();
  }elseif(array_key_exists('delete_entry', $_POST)){
    //if user selected a row to delete_entry
    if(array_key_exists('entries', $_POST)){
      $entries = $_POST['entries'];
      deleteEntries($entries);
    }
    header('Location: homepage.php');
    exit;
  }
  elseif(array_key_exists('username', $_POST)){
    $input_username = $_POST["username"];
    $input_password = $_POST["pword"];
    insertEntry($input_username,$input_password);
  }
}







function showDatabase(){
  global $host;
  global $db_name;
  global $username;
  global $password;
  try {
    // 2. connect to database
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //preparing and running query
    $query = "SELECT * FROM users ORDER BY username";
    $stmt = $con->prepare( $query );
    $stmt->execute();

    //showing results
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $username = $row['username'];
      $password = $row['passwords'];
      echo "
      <p class='col-md-5'>${username} </p>
      <p class='col-md-5'>${password} </p>
      <input type='checkbox'  class='col-md-2'  name='entries[]' value='${username}'><br/>
      ";

    }
  }

  catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $con = null;
}

function generateDBTable(){
  $sampleUsers = array("Joe","Sam","Cait","Jake","Raymond");
  foreach($sampleUsers as $user){
    $rand_pass = rand(10000000,99999999);
    $insert_query = "INSERT INTO users(username, passwords) VALUES ('$user','$rand_pass')";
    runQuery($insert_query);
  }
}



//NEEDS TO BE UPDATED, SQL INJECTION DANGER
function deleteEntries($entries){
  foreach($entries as $entry){
    $query = "DELETE FROM users WHERE username='${entry}';";
    runQuery($query);
  }
}

function runQuery($query){
  global $host;
  global $db_name;
  global $username;
  global $password;
  //inserting data into database
  try {
    // 2. connect to database
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->exec($query);
    //echo "<p>Query ran successfully </p>";
  }
  catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $con = null;
}



/*
//inserting data into database
$sampleUsers = array("Joe","Sam","Cait","Jake","Raymond");
foreach($sampleUsers as $user){
$rand_pass = rand(10000000,99999999);
$insert_query = "INSERT INTO users(username, passwords) VALUES ('$user','$rand_pass')";
runQuery($insert_query);
}


//Deleting data from database
$query = "DELETE FROM users";
runQuery($query);
*/

//NEEDS TO BE UPDATED, SQL INJECTION DANGER
function insertEntry($input_username, $input_password){
  global $feedback;
  $feedback = "insert entry";
  //if check input returns true, then a new entry can be made
  if(validateInput($input_username, $input_password)){
    $insert_query = "INSERT INTO users VALUES ('$input_username','$input_password')";
    runQuery($insert_query);
    //sends user back to same page (this cleans _POST variable)
    header('Location: submited.php');
    exit;
  }
}

//Returns true if input is good to be stored in db
//needs to add sql sanitisation, string length range
function validateInput($username, $password){
  global $feedback;
  $input_username = filter_var($username, FILTER_SANITIZE_STRING);
  $input_password = filter_var($password, FILTER_SANITIZE_STRING);
  $len_username = strlen($input_username);
  $len_password = strlen($input_password);
  #checking if username and password contain spaces
  if(checkSpaces($input_username)){
    $feedback = "Your username cannot have spaces";
    return false;
  }elseif(checkSpaces($input_password)){
    $feedback = "your password cannot have spaces";
    return false;
  }elseif($len_username < 2 || $len_username > 30){
    $feedback = "Username length must be between 2 and 30 characters";
    return false;
  }elseif($len_password < 7 || $len_username > 30){
    $feedback = "password length must be between 7 and 30 characters";
    return false;
  }else{
    //input username must be compared with db
    if(checkUsername($input_username)){
      $feedback = "Sorry but this username already exists, try a different one";
      return false;
    }else{
      return true;
    }
  }
}

function checkSpaces($input){
  $pattern = " ";
  if(strpos($input, $pattern) === false){
    return false;
  }else{
    return true;
  }
}

function checkUsername($input){
  global $host;
  global $db_name;
  global $username;
  global $password;
  try {
    // 2. connect to database
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("SELECT * from users WHERE username=?");
    $query->execute([$input]);
    //getting result from query
    $result = $query->fetch();
    if($result){
      //username already exists
      return true;
    }else{
      //username does not exist
      return false;
    }
  }
  catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $con = null;
}





?>
