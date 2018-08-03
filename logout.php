<?php

session_start();
//if the users's browser sent a cookie for that session
if(isset($_COOKIE[session_name()])){
    
    //empty the cookie
    setcookie(session_name(),'',time()-86400,'/');//time in sec (30 *86400)
}
//clear all session variables
session_unset();

//after clearing it is important to destroy the session
session_destroy();
include_once('header.php');
?>

<div class="container">
    
<div class='alert alert-success'>You logged out Successfully! <a class='close' id='close-alert' data-dismiss='alert'>&times;</a></div>
    <div>
            <a href="index.php" type="button" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-user">login!</span></a>
    </div>
<!--    </p>-->
</div>

<?php
include_once('footer.php');
?>