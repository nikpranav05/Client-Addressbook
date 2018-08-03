<?php
 
    session_start();

    //check whether user has already logged in or not

    if(!$_SESSION['loggedInUser']){
        //send the user to login page
        header("Location: index.php");
    }
    //connect the database
    include_once('connection.php');

    //custom function file include
    include_once('functions.php');
  
    $setSql = "SELECT `name`,`email`,`phone`,`address`,`company`,`notes` FROM `clients`";  
    $setRec = mysqli_query($conn, $setSql);

    $columnHeader = '';  
    $columnHeader = "Name"."\t"."Email"."\t"."Phone"."\t"."Address"."\t"."Company"."\t"."Notes";  

    $setData = '';  

    while ($rec = mysqli_fetch_row($setRec)) {  
        $rowData = '';  
        foreach ($rec as $value) {  
            $value = '"' . $value . '"' . "\t";  
            $rowData .= $value;  
        }  
        $setData .= trim($rowData) . "\n";  
    }  


    header("Content-type: application/octet-stream");  
    header("Content-Disposition: attachment; filename=ClientDetails.xls");  
    header("Pragma: no-cache");  
    header("Expires: 0");  

    echo ucwords($columnHeader) . "\n" . $setData . "\n";  

?>