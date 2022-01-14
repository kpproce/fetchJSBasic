<?php   
    //https://www.youtube.com/watch?v=OEWXbpUMODk
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // required headers
    // header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
    $returnData = "leeg"; 
    if (empty($_POST)) {
        // no data passed by POST
        $returnData = "Je hebt geen POST parameters meegestuurd<br>
        Stuur parameter nummer (tussen 0 en 5) mee, bijv nummer=5 
        en stuur de code voor toegang bijv code=gast of admin";
    } else {
       
        $returnData = "POST gebruikt.. <br> ";
        if (isset($_POST['code'])) {
            $code = strtolower($_POST["code"]);
        } else {
            // er is geen code als parameter gevonden
            $code = "";
        }

        if ( $code == "") { // let op verschil code niet als parameter meegegeven of leeg doorgegeven
            $returnData = "Je hebt GEEN code doorgegeven. Je wordt dan automatisch gast<br>";
        }

        if (isset($_POST['nummer'])) {
            $nummer = strtolower($_POST["nummer"]);
        } else {
            $nummer = "";
        }

        if ( $nummer == "") { // let op verschil nummer niet als parameter meegegeven of leeg doorgegeven
            $returnData .= "Je hebt GEEN nummer doorgegeven. <br>";
        } else {
            $returnData .= "Het door jou ingevoerde nummer is $nummer <br>";
                  // probeer nummer te lezen
            if (is_numeric($nummer)) {
                $returnData .= " nummer toegestaan";
            } else {
                $returnData .= "XX dit is GEEN geldig nummer<br>";
            }
        }

        if ($code=="admin") {
            $returnData .= "Je bent ADMINISTRATOR, je hebt rechten. \nJe hebt bij nummer: $nummer ingevuld <br>";
            $returnData .= "URL: ".  $_SERVER['REQUEST_URI'];
       
        } else {
            $returnData .= "Je bent GAST je mag rondkijken. ";
        }

  

    }

    

    // let op dat je echt alleen data terug stuurt. En liefst in JSON format
    echo $returnData;
?>