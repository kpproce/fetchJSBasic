<?php   
    //https://www.youtube.com/watch?v=OEWXbpUMODk
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // required headers
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $toegangsCode = "";
    $toegang = "gast"; // standaard toegang

    $studentFilter     = ""; // Leeg betekent alle studenten
    $opdrachtFilter    = ""; // Leeg betekent alle opdrachten
    $afgerondMinFilter = ""; 
    $afgerondMaxFilter = "";

    // voor een uodate van de voortgang moet: 
    // -- updateVoortgang een getal hebben en 
    // -- CRUD update zijn en 
    // -- je moet een valide code hebben meegestuurd
    $updateVoortgang   = ""; 
    $crud = "read"; // standaard is read.

    $info = "";
    $errorInfo = "";
    $where = "";
    

    // database connection will be here

    include_once 'Database_opdrachten.php'; // is een class/object
    include_once 'read_opdrachten_params.php'; 
    // in read_opdrachten_params.php worden de parameters die meegegeven zijn gelezen, dit is vooral voor de leesbaarheid

    if ($toegangsCode == "Astrum22") { // dit moet uiteraard veiliger.
        $toegang="edit";  
    }

    // dit deel is belangrijk, want updaten mag niet zomaar
    // verdiep jezelf in sqlinjections
    if ($crud=='update') {
        if ($toegang=='edit')
        $info = "update is naar database verstuurd"; 
    } else {
        $info = "update niet mogelijk als gast, stuur juiste toegangsCode mee";
    }

    // dit deel nog niet geimplementeerd
    if (isset($_GET['maxAantal'])) {
        $maxAantalGet = intval(strtolower($_GET["maxAantal"]));
        if ($maxAantalGet>0) {
            $maxAantal= " LIMIT " . $maxAantalGet  ;
        }
    }

   // verdiep jezelf in sqlinjections, https://www.w3schools.com/sql/sql_injection.asp
   // zit nog niet in onderstaande code
    $sql = "SELECT * FROM overzicht_opdrachten $where " ;

    // print ($sql . "\r\n\r\n" );
    // print ('ContainsTextGet: '. $ContainsTextGet. "\r\n" );
    // print('--------SELECT * FROM zinnen ' . $where. $wheretst .   $order);
    // echo "*************** $sql ***************";

    $database = new Database();      // get database connection
    $db = $database->getConnection();
    
    // lees de gegevens uit de database.  
    $resultData = $database->getData_AssArray($sql); 
    
    // printf("Error message: %s\n", $database->error);  
    // echo "<div>" . $database->getData_HTMLTable($resultData) . "</div>" ;
    // echo "<br>";
    // zet het resultaat om in JSON format

    // $postDataJson[] = $resultData;

    $response = [
        'post'          => $_POST,
        'info'          => $info,
        'student'       => $studentFilter,
        'errorInfo'  	=> $errorInfo,
        'crud'          => $crud,
        'toegang'       => $toegang,
        'where'         => $where,
        'max filter'     => $afgerondMaxFilter,
        'min filter'     => $afgerondMinFilter,
        'data'=> $resultData
    ];

    echo json_encode($response);
    
?>