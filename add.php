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


    //setting variables to blank
    $nameError=$emailError="";
    if(isset($_POST['add'])){
        //setting all data variables to blank
        $clientName=$clientEmail=$clientPhone=$clientAddress=$clientCompany=$clientNotes="";
        if(!$_POST['clientName']){
            $nameError="Please enter a name<br>";
        }
        else{
            $clientName=validateFormData($_POST['clientName']);
        }
        
        if(!$_POST['clientEmail']){
            $emailError="Please enter an email";
        }
        else{
            $clientEmail=validateFormData($_POST['clientEmail']);
        }
        
        //foll are the not required so we directly take them
        $clientPhone=validateFormData($_POST['clientPhone']);
        $clientAddress=validateFormData($_POST['clientAddress']);
        $clientCompany=validateFormData($_POST['clientCompany']);
        $clientNotes=validateFormData($_POST['clientNotes']);        
        
        //checking if there was error or not
        if($clientName && $clientEmail){
            $query="INSERT INTO clients(name,email,phone,address,company,notes,created_at,updated_at) VALUES('$clientName','$clientEmail','$clientPhone','$clientAddress','$clientCompany','$clientNotes',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
            $role='';
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
    mysqli_close($conn);
    include_once('header.php');

?>

   <div class="container">
   <?php
    if($nameError || $emailError){
    ?>    
    <div class="alert alert-danger">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <strong>ERROR  </strong><br/><?php echo $nameError.$emailError;?>
   </div>
   <?php
   }
    ?>
    <h1><center>Add Client</center></h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="row">
        <div class="form-group col-md-6">
            <label for="client-name">Name *</label>
            <input type="text" class="form-control input-lg" id="client-name" name="clientName">
        </div>
        
        <div class="form-group col-md-6">
            <label for="client-email">Email *</label>
            <input type="text" class="form-control input-lg" id="client-email" name="clientEmail">
        </div>
        
        <div class="form-group col-md-6">
            <label for="client-phone">Phone</label>
            <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone">
        </div>
      
        <div class="form-group col-md-6">
            <label for="client-address">Address</label>
            <textarea class="form-control input-lg" id="client-address" name="clientAddress" rows="2"></textarea>
        </div>
  
        <div class="form-group col-md-6">
            <label for="client-company">Company</label>
            <input type="text" class="form-control input-lg" id="client-company" name="clientCompany">
        </div>
        
        <div class="form-group col-md-6">
            <label for="client-notes">Notes</label>
            <input type="text" class="form-control input-lg" id="client-notes" name="clientNotes">
        </div>
        

        <div class="col-md-12">
            <a href="<?php 
                     $role='';
                     if(isset($_SESSION['roleFlag'])){
                         if($_SESSION['roleFlag']==1)
                             $role='admin';
                         else
                             $role='user';
                     }
                     echo 'clients.php?role='.$role; ?>" type="button" class="btn btn-lg btn-warning">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add Client</button>
        </div>
    </form>
</div>
<?php

    include_once('footer.php');
?>