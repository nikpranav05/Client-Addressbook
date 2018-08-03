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

    if(isset($_GET['id'])){
        
    }

?>
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal">&times;</button>
                               <h4 class="modal-title">Are you sure you want to delete this data?</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success pull left" id="modal-yes" name="delete">Yes</button>
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>                   
                            </div>
                        </div>
                    </div>
                </div>';
