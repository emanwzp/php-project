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
    cleanTable();
  }elseif(array_key_exists('gen_table', $_POST)){
    generateTable();
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

//Returns a PDO connection to the database
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


//Returns html elements for each table entry (username, pw, and respective checkbox)
function showTable(){
  try {
    // 2. connect to database
    $con = getConnection();
    //preparing and running query
    $query = "SELECT * FROM users ORDER BY username";
    $stmt = $con->prepare( $query );
    $stmt->execute();

    //showing results
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $username = $row['username'];
      $password = $row['passwords'];
      echo "
      <p class='col-sm-5 col-md-5'>${username} </p>
      <p class='col-sm-5 col-md-5'>${password} </p>
      <input type='checkbox'  class='col-sm-2 col-md-2'  name='entries[]' value='${username}'><br/>
      ";

    }
  }
  catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $con = null;
}


//Generates an entry on the users table, for each user in the $sampleUsers array
//with a random generated pw (mostly for demo purposes)
function generateTable(){
  $sampleUsers = array("Joe","Sam","Cait","Jake","Raymond");
  foreach($sampleUsers as $user){
    $rand_pass = rand(10000000,99999999);
    $con = getConnection();
    $insert_query = "INSERT INTO users(username, passwords) VALUES (? , ?)";
    $sth = $con->prepare($insert_query);
    $sth->bindParam(1, $user);
    $sth->bindParam(2, $rand_pass);
    $sth->execute();
  }
}

//Deletes all entries from a table
function cleanTable(){
  $query = "DELETE FROM users";
  runQuery($query);
}



//For each entry selected on the checkboxes, it deletes the entry with the
//same username
function deleteEntries($entries){
  foreach($entries as $entry){
    $entry = filter_var($entry, FILTER_SANITIZE_STRING);
    $con = getConnection();
    $query = "DELETE FROM users WHERE username=?;";
    $sth = $con->prepare($query);
    $sth->bindParam(1,$entry);
    $sth->execute();
  }
}


//Runs generic query(passed as a function parameter) that has no parameters
function runQuery($query){
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





//After validating input, it adds an entry to the users table
function insertEntry($input_username, $input_password){
  global $feedback;
  $feedback = "insert entry";
  $input_username = filter_var($input_username, FILTER_SANITIZE_STRING);
  $input_password = filter_var($input_password, FILTER_SANITIZE_STRING);

  //if check input returns true, then a new entry can be made
  if(validateInput($input_username, $input_password)){
    $con = getConnection();
    $insert_query = "INSERT INTO users VALUES (?, ?)";
    $sth = $con->prepare($insert_query);
    $sth->bindParam(1, $input_username);
    $sth->bindParam(2, $input_password);
    $sth->execute();
    /*sends user to another page
    if the goal is to remain on the same page, it is still good to use
    header + exit anyway since this will clean the POST variable*/
    header('Location: submited.php');
    exit;
  }
}

//Returns true if input is good to be stored in db, or false otherwise
//it checks for spaces, string length and if username already exists
function validateInput($input_username, $input_password){
  global $feedback;
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

//checks if string passed as parameter contains spaces
function checkSpaces($input){
  $pattern = " ";
  if(strpos($input, $pattern) === false){
    return false;
  }else{
    return true;
  }
}

//checks if username already exists in the database
function checkUsername($input){
  try {
    $con = getConnection();
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
