<?php
    
    session_start();
    if(!isset($_SESSION['loggedInUser'])){
        //send them to login
        header("Location: index.php");
    }
    //connect to database
    include('connection.php');

//    global $roleFlag=0;
    //query and result
    $query="SELECT * FROM clients";
    $result=mysqli_query($conn,$query);

    $alertMessage="";
    if(isset($_GET['alert'])){
        if($_GET['alert']=='success'){
            $alertMessage= "<div class='alert alert-success'>New Client Added<a class='close' id='close-alert' data-dismiss='alert'>&times;</a></div>";

        }
    }
    else if(isset($_GET['role'])){
        if($_GET['role']=='admin'){
            $_SESSION["roleFlag"]=1;
        }
    }

    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $role="";
        $query="DELETE FROM clients WHERE id='$id';";
        $result=mysqli_query($conn,$query);
        if($result){
            if(isset($_SESSION["roleFlag"])){
                if($_SESSION["roleFlag"]==1)
                    $role="admin";
                else
                    $role="user";
            }
            header("Location: clients.php?role=".$role);
        }
        else{
            echo "Error:".$query."<br>".mysqli_error($conn);
        }
    }

    include_once('header.php');

?>

<div class="container">
    <h1>Client Address Book</h1>
    <?php
        if($alertMessage){
            echo $alertMessage;
        }
    ?>
    <table class="table table-striped table-bordered table-responsive">
        
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Company</th>
            <th>Notes</th>
            <th>Edit</th>
            <?php
            if(isset($_SESSION["roleFlag"])){
                if($_SESSION["roleFlag"]==1)
            {?>
            <th>Delete</th><?php }}?>
        </tr>
        <?php
//        session_start();
        if(mysqli_num_rows($result)>0){
            //we have data
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$row['name']."</td><td>".$row['email']."</td><td>".$row['phone']."</td><td>".$row['address']."</td><td>".$row['company']."</td><td>".$row['notes']."</td>";
                    
                echo '<td><a href="edit.php?id='.$row['id'].'" type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-edit"></span></a></td>'; 
                if(isset($_SESSION["roleFlag"]))
                {
                    if($_SESSION["roleFlag"]==1){
                   
//            Triggering modal with a button
                $i=$row['id'];
                echo '<td><button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal'.$i.'"><span class="glyphicon glyphicon-trash"></span></button></td>';
                
                    ?>
                <div id="myModal<?php echo $i?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal">&times;</button>
                               <h4 class="modal-title">Are you sure you want to delete this data?</h4>
                               </div>
                               <div class="modal-footer">
                                  <a href="clients.php?id=<?php echo $i?>" type="button" id="yes-wala-button" class="btn btn-success">Yes</a>
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>                   
                              </div>
                           </div>
                       </div>
                    </div>

                <?php
                }}
                echo "</tr>";
                
            }
        }
        else{
            //there are no entries
            echo "<div class='alert alert-warning'>You have no clients</div>";
        }    
        ?>
    </table>
<!--
        <tr>
            <td colspan="7">
-->
                <div class="text-center">
                    <a href="add.php" type="button" class="btn btn-success btn-lg">
                        <span class="glyphicon glyphicon-plus">&nbsp;Add Client</span>
                    </a> &nbsp;&nbsp;
                    <a data-toggle="modal" data-target="#import_csv" type="button" class="btn btn-success btn-lg">
                        <span class="glyphicon glyphicon-plus">&nbsp;Import data</span>
                    </a> &nbsp;&nbsp;
                    <a href="export.php" type="button" class="btn btn-success btn-lg">
                        <span class="glyphicon glyphicon-plus">&nbsp;Export data</span>
                    </a>
                </div>
                
                                    
                    <div id="import_csv" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal">&times;</button>
                               <h4 class="modal-title">Import CSV File</h4>
                               </div>
                               <div>
                                    <form class="form-horizontal well" action="import.php" method="post" name="upload_excel" enctype="multipart/form-data">
                                    <fieldset>
                                    <div class="control-group">
                                        <div class="control-label">
                                            <label>CSV/Excel File:</label>
                                        </div>
                                        <div class="controls">
                                            <input type="file" name="file" id="file" class="input-large">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
                                        </div>
                                    </div>
                                    </fieldset>
                                </form>
                                   
                               </div>
                               <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>                   
                              </div>
                           </div>
                       </div>
                    </div>
<!--
            </td>
        </tr>
-->
    
</div>
<?php
include_once('footer.php');
?>