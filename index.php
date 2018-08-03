<?php 

include('connection.php');
session_start();
$_SESSION["roleFlag"]=0;
$firstNameError = $lastNameError = $passwordError = $emailError = "";
$flag=0;
$tokenN=0;
$tokenE=0;
if(isset($_POST['add']))
{
    
    //build a function that validates the data
    function validateFormData($formData){
        $formData = trim(stripslashes(htmlspecialchars($formData)));
        return $formData;
    }
    //check for inputs
    $email = $lname = $fname = $password = $role = "";
    
    $queryN="SELECT first_name FROM users";
    $resultN=mysqli_query($conn,$queryN);
    if(!$resultN){
        echo "Problem with database";
    }
    else{
        while($row=mysqli_fetch_assoc($resultN)){
            if(strcmp($_POST['fname'],$row['first_name'])==0){
            $tokenN=1;
            }
        }
    }
    
    $queryE="SELECT email FROM users";
    $resultE=mysqli_query($conn,$queryE);
    if(!$resultE){
        echo "Problem with database";
    }
    else{
        while($row=mysqli_fetch_assoc($resultE)){
            if(strcmp($_POST['email'],$row['email'])==0){
                $tokenE=1;
            }
        }
    }

    
    if(!$_POST['fname']){
        $firstNameError = "Please Enter a Name";
        $flag=1;
    }
    else if($tokenN==1){
        $firstNameError = "This Name is Already Used";
        $flag=1;
    }
    else{
        $fname = validateFormData($_POST['fname']);
        if($fname=='admin' || $fname=='Admin'){
            $firstNameError = "Cannot use admin";
            $flag=1;
        }
    }
//
//    if(!$_POST['role']){
//        $roleError = "Please mention your role";
//        $flag=1;
//    }
//    else{
//        $role = validateFormData($_POST['role']);
//    }
    
    if(!$_POST['lname']){
        $lastNameError = "Please Enter a Name";
        $flag=1;
    }
    else{
        $lname = validateFormData($_POST['lname']);
        if($lname=='admin' || $lname=='Admin'){
            $lastNameError = "Cannot use admin";
            $flag=1;
        }
    }

    if(!$_POST['email']){
        $emailError = "Please Enter a Email";
        $flag=1;
    }
    else if($tokenE==1){
        $emailError = "This Email is Already Used";
        $flag=1;
    }
    else{
        $email = validateFormData($_POST['email']);
    }
    
    if(!$_POST['password']){
        $passwordError = "Please Enter a Password";
        $flag=1;
    }
    else{
        $password = password_hash(validateFormData($_POST['password']),PASSWORD_DEFAULT);
    }
    
    if($fname && $lname && $email && $password){
        
        //password checking
        $passFName=$_POST['fname'];
        $passLName=$_POST['lname'];
        $Email=explode("@",$_POST['email']);
        $passEmail=$Email[0];
        $passCheck=$_POST['password'];
        
        if((stristr($passCheck,$passFName)==false)&&(stristr($passCheck,$passLName)==false)&&(stristr($passCheck,$passEmail)==false)&&(stristr($passCheck,$passFName.$passLName)==false)&&(stristr($passCheck,$passLName.$passFName)==false)&&(stristr($passCheck,$passFName.$passEmail)==false)&&(stristr($passCheck,$passEmail.$passFName)==false)){
            $query="Insert into users(first_name,last_name,email,password) values ('$fname','$lname','$email','$password')";
            if(mysqli_query($conn,$query)){
                echo "<div class='alert alert-success'>New record in database</div>";
            }
        }
        else{
            $passwordError="Password is invalid.";
            $flag=1;
        }
    }
    else{
//        echo "<div class='alert alert-danger'>".mysqli_error($conn)."</div>";
    }
}

?>
<?php
$loginError="";
//$user="";
if(isset($_POST['login'])){
    
    include('functions.php');
    //create variables to store HTML data
    //wrap the data with out validating function
    $formUser=validateFormData($_POST['username']);
    $formPass=validatePassword($_POST['password']);
//    $formRole=validateFormData($_POST['role']);
    //connect to database
    include('connection.php');
    
    //create a SQL query
    $query="SELECT first_name,last_name,password from USERS where first_name='$formUser';";
    
    //store the result
    $result=mysqli_query($conn,$query);
    
    //verify if result is returned
    if(mysqli_num_rows($result)){
        
        //if there are some rows
        if(mysqli_num_rows($result)>1){
            $loginError="<div class='alert alert-danger'>There is some error in database! Please contact the admin <a class='close' data-dismiss='alert'>&times;</a></div>";
        }
        
        else{
            //correct user found && store the basic user info in variables
            if($row=mysqli_fetch_assoc($result)){
//                $role=$row['role'];
                $user=$row['first_name'];
                $hashedPass=$row['password'];
                if($user=='admin') 
                    $role='admin';
                else
                    $role='user';
            
            
                //verify whether the hashed password and the entered password is correct
                if(password_verify($formPass,$hashedPass)){
                    //correct login details
                    //session will be started
                    session_start();

                    //store the data is session variables
                    $_SESSION['loggedInUser']=$user;
                    $_SESSION['loggedInEmail']=$email;

                    header("Location: clients.php?role=".$role);
                }
                else{
                    //password not verified
                    $loginError="<div class='alert alert-danger'>Wrong username or password! Try AGAIN! <a class='close' data-dismiss='alert'>&times;</a></div>";
                }
            }
        }
    }
    else{
        $loginError="<div class='alert alert-danger'>No such user found in database! Please try again! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    //close the connection
    mysqli_close($conn);
}//end of isset if

include_once('header.php');
?>

       <div class="main-container">
        <ul class="nav nav-tabs">
            <li <?php if($flag==0){?>class="active"<?php }?>><a data-toggle="tab" href="#login"><strong>Login</strong></a></li>
            <li <?php if($flag==1){?>class="active"<?php }?>><a data-toggle="tab" href="#signup"><strong>Sign Up</strong></a></li>
        </ul>
        <?php
        if($loginError){
            echo $loginError;
        }
        ?>
        
    <div class="tab-content">
        <div id="login" class="tab-pane fade <?php if($flag==0){?>in active<?php }?>">     
            <form class="form-vertical" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        
<!--
        <div class="form-group">
            <label for="login-password" class="sr-only">Role</label>
            <input type="text" id="login-role" name="role" placeholder="Role (User/Admin)" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Please enter role">
        </div>
-->
              
        <div class="form-group">
            <label for="login-username" class="sr-only">Username</label>
            <input type="text" id="login-username" name="username" placeholder="Username" class="form-control">
        </div>

        <div class="form-group">
            <label for="login-password" class="sr-only">Password</label>
            <input type="password" id="login-password" name="password" placeholder="Password" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Please enter password">
        </div>
        
        
        <button id="login-btn" type="submit" class="btn btn-primary" name="login">LOGIN</button>
        
        </form>
        </div>
        <div id="signup" class="tab-pane fade <?php if($flag==1){?>in active<?php }?>">
        <form action="<?php echo ($_SERVER['PHP_SELF']); ?>" method="POST">
        <p class="text-danger">* Required</p>
            <div class="form-group">
                <small class="text-danger"><?php echo "$firstNameError";?></small>    
                <input type="text" name="fname" placeholder="First Name *" class="form-control">
            </div>

            <div class="form-group">
                <small class="text-danger"><?php echo "$lastNameError";?></small>    
                <input type="text" name="lname" placeholder="Last Name *" class="form-control">
            </div>
               
            <div class="form-group">
                <small class="text-danger"><?php echo "$emailError";?></small>
                <input type="email" name="email" placeholder="Email ID *" class="form-control">
            </div>
            <div class="form-group">
                <small class="text-danger"><?php echo "$passwordError";?></small>
                <input type="password" name="password" placeholder="Password *" class="form-control">
            </div>
<!--
            <div class="form-group">
                <small class="text-danger"><php  echo "$roleError";?></small>
                <input type="text" name="role" placeholder="Role(User/Admin)*" class="form-control">
            </div>
-->
            
        <button id="add-btn" type="submit" name="add" class="btn btn-primary">Add Entry</button>    
        </form>
        </div>
    </div>
</div>

<?php

include_once('footer.php');

?>