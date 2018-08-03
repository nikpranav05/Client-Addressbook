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
    if(isset($_POST["Import"])){
		echo $filename=$_FILES["file"]["tmp_name"];
 
		 if($_FILES["file"]["size"] > 0)
		 {
 		  	$file = fopen($filename, "r");
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
 
	          //It wiil insert a row to our subject table from our csv file`
	           $query="INSERT INTO clients(name,email,phone,address,company,notes,created_at,updated_at) VALUES('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
	         //we are using mysql_query function. it returns a resource on true else False on error
	                      $result=mysqli_query($conn,$query);
            //check if successfully updated
            if($result){
                     if(isset($_SESSION['roleFlag'])){
                         if($_SESSION['roleFlag']==1)
                             $role='admin';
                         else
                             $role='user';
                     }
                //? ko get parameter chaiye and its called query_string
                //refreshing clients.php with new data and query string
                header("Location: clients.php?alert=success?role=".$role);
            }
            else{
                echo "Error:".$query."<br".mysqli_error($conn);
            }
	         
		 }
	   }
        fclose($file);
	         //throws a message if data successfully imported to mysql database from excel file
	         //close of connection
			mysqli_close($conn); 
    }
?>