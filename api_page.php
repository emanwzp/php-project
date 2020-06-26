<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <link rel="shortcut icon" href="Assets\favicon.ico"/>
  <title>API Exercise</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css"/>
</head>

<body>
  <div class="container">
    <div class="main-body">
      <div class="main-container">

        <?php include 'navigation_panel.php';?>

        <h1>Searching for advice with an API</h1>
        <p></p>


        <form method="GET">
          <label for="advice">Input the word you want advice for:</label><br>
          <!-- value= <?php if(array_key_exists('advice', $_GET)){echo $_GET["advice"];}?> -->
          <input type="text" id="advice" name="advice_input" ><br>
          <p> </p>
          <input type="submit" name='advice' value="Ask for Advice">
          <input type="submit" name="random_advice" value="Get Random Advice">

        </form>

        <p></p>

        <?php
        $api_source = "https://api.adviceslip.com/advice";

        $input = "";
        if($_SERVER["REQUEST_METHOD"] === "GET"){
          if(array_key_exists('advice', $_GET)){
            getAdvice();
          }elseif(array_key_exists('random_advice', $_GET)){
            getRandomAdvice();
          }
        }

        function getAdvice(){
          $input = $_GET['advice_input'];
          //check if user input multiple words by trimming and checking the
          //position of the space character
          $multiple_words = strpos(trim($input), ' ');
          if($multiple_words === false && $input){
            global $api_source;
            $api_stream = fopen($api_source . "/search/" . $input,"r");
            $contents_api = stream_get_contents($api_stream);
            fclose($api_stream);
            //converting to php object by decoding json
            $contents_api = json_decode($contents_api);
            //getting the slips atribute from the object if property exists
            if(property_exists($contents_api,"slips")){
              echo "<h3>Getting advice on: ${input}</h3>";
              $slips = $contents_api->slips;
              foreach($slips as $object){
                echo "<p>$object->advice</p>";
              }
            }else{
              echo "<p>We could not find advice for your word</p>";
            }
          }else{
            echo "<p>Please input just one word</>";
          }
        }

        function getRandomAdvice(){
          global $api_source;
          $api_stream = fopen($api_source,"r");
          $contents_api = stream_get_contents($api_stream);
          fclose($api_stream);
          //converting to php object by decoding json
          $contents_api = json_decode($contents_api);

          //getting the slip atribute from the object if property exists
          if(property_exists($contents_api,"slip")){
            $slip = $contents_api->slip;
            $advice = $slip->advice;
            echo "<h3>Here is some advice</h3>
                <p>$advice</p>";
          }else{
            echo "<p>Sorry we could not find any advice at this time</p>";
          }

        }

        ?>


      </div>
    </div>
  </div>


  <?php include 'footer.php';?>
</body>
