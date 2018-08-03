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

    $query="";

    $clientName=$clientEmail=$clientAddress=$clientPhone=$clientCompany=$clientNotes="";
    $error="";
    $id="";
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query="SELECT * from clients where id='$id'";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)){
            if(mysqli_num_rows($result)>1){
                $error="<div class='alert alert-danger'>There is some error in database! Please contact the admin <a class='close' data-dismiss='alert'>&times;</a></div>";
            }
            else{
                $row=mysqli_fetch_assoc($result);
                $clientName=$row['name'];
                $clientEmail=$row['email'];
                $clientPhone=$row['phone'];
                $clientAddress=$row['address'];
                $clientCompany=$row['company'];
                $clientNotes=$row['notes'];
            }
                
        }
    }
    $query3="";
    if(isset($_POST['delete'])){
        $id=$_GET['id'];
        $query3="DELETE FROM clients WHERE id='$id';";
        $result2=mysqli_query($conn,$query3);
            //check if successfully updated
            if($result2){
                //? ko get parameter chaiye and its called query_string
                //refreshing clients.php with new data and query string
                header("Location: clients.php");//?alert=success");
            }
            else{
                echo "Error:".$query3."<br".mysqli_error($conn);
            }
    
    }

    $query2="";
    if(isset($_POST['update'])){
        //$clientName=$clientEmail=$clientPhone=$clientAddress=$clientCompany=$clientNotes="";
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
            $role="";
            $query2="UPDATE clients SET name='$clientName',email='$clientEmail',phone='$clientPhone',address='$clientAddress',company='$clientCompany',notes='$clientNotes',updated_at=CURRENT_TIMESTAMP WHERE id='$id';";
            $result1=mysqli_query($conn,$query2);
            //check if successfully updated
            if($result1){
                if(isset($_SESSION["roleFlag"])){
                    if($_SESSION["roleFlag"]==1)
                        $role="admin";
                    else
                        $role="user";
                }
                //? ko get parameter chaiye and its called query_string
                //refreshing clients.php with new data and query string
                header("Location: clients.php?role=".$role);//?alert=success");
            }
            else{
                echo "Error:".$query2."<br".mysqli_error($conn);
            }
        }

    }
    mysqli_close($conn);
    include_once('header.php');
?>
<div class="container">
   <?php
        if(isset($error)){
            echo $error;
        }
    ?>
    <h1>Add Client</h1>
    <?php 
        $id=$_GET['id'];
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?id=$id";?>" method="post" class="row">
        <div class="form-group col-md-6">
            <label for="client-name">Name *</label>
            <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $clientName;?>">
        </div>
        
        <div class="form-group col-md-6">
            <label for="client-email">Email *</label>
            <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $clientEmail;?>">
        </div>
        
        <div class="form-group col-md-6">
            <label for="client-phone">Phone</label>
            <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $clientPhone;?>">
        </div>
      
        <div class="form-group col-md-6">
            <label for="client-address">Address</label>
            <textarea class="form-control input-lg" id="client-address" name="clientAddress" rows="2"><?php echo $clientAddress;?></textarea>
        </div>
  
        <div class="form-group col-md-6">
            <label for="client-company">Company</label>
            <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo $clientCompany;?>">
        </div>
        
        <div class="form-group col-md-6">
            <label for="client-notes">Notes</label>
            <input type="text" class="form-control input-lg" id="client-notes" name="clientNotes" value="<?php echo $clientNotes;?>">
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
                     echo 'clients.php?role='.$role;?> " type="button" class="btn btn-lg btn-warning">Cancel</a>
            <div class="pull-right">
                <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
<!--                <button type="submit" class="btn btn-lg btn-success" name="delete">Delete</button>-->
            </div>
        </div>
    </form>
</div>