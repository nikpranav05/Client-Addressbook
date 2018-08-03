<!DOCTYPE html>

<html>

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Client Address Book</title>
<!--        Custom CSS for index file-->
<!--    <link href="bootstrap.css" type="text/css" rel="stylesheet">-->

        <link rel="stylesheet" type="text/css" href="styles.css">
        <link href="normalize.css" type="text/css" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        
        <!--Custom CSS -->
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body style="padding-top: 60px;">
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php 
                                                 $role='';
                                                 if(isset($_SESSION['roleFlag'])){
                                                     if($_SESSION['roleFlag']==1)
                                                         $role='admin';
                                                     else
                                                         $role='user';
                                                 }
                                                 echo 'clients.php?role='.$role; ?>">CLIENT <strong>MANAGER</strong></a>
                </div>
                    <?php
                        if(isset($_SESSION['loggedInUser'])){
                            ?>
                            <div class="collapse navbar-collapse" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php 
                                             $role='';
                                             if(isset($_SESSION['roleFlag'])){
                                                 if($_SESSION['roleFlag']==1)
                                                     $role='admin';
                                                 else
                                                     $role='user';
                                             }
                                             echo 'clients.php?role='.$role; ?>">My Client</a></li>
                                <li><a href="add.php">Add Client</a></li>
                                
                            </ul>
                            <div class="navbar-header pull-right"><a class="navbar-brand" href="<?php 
                                                                                                 $role='';
                                                                                                 if(isset($_SESSION['roleFlag'])){
                                                                                                     if($_SESSION['roleFlag']==1)
                                                                                                         $role='admin';
                                                                                                     else
                                                                                                         $role='user';
                                                                                                 }
                                                                                                 echo 'clients.php?role='.$role; ?>">Hello <?php echo $_SESSION['loggedInUser'];?></a></div>
                            <ul class="nav navbar-nav navbar-right" id="nav-logout">
                                <li><a href="logout.php">Log Out</a></li>
                            </ul>
                            </div>
                            
                        <?php
                        }
                    
                    ?>
            </div>
        </nav>