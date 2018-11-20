<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include "validate.php";
include_once "dbconn.php";
session_start();
//echo "connected successfuly";
$que = "SELECT room_type FROM room_type";
$sql = $conn->query($que);
$result = $sql->fetch_All();
$que1 = "SELECT DISTINCT city FROM room";
$uniqueRes = dbquery($que1, $conn);
//var_dump($uniqueRes);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CheapTel.com</title>
        <!-- Meta Tags --->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- Bootstrap --->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <!--- FontAwesome --->  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
        
        <!--- Local Scripts --->
        <link rel="stylesheet" href="/css/styles.css">
        <link rel="stylesheet" href="/css/indexstyles.css">
        <script src="js/script.js"></script>

    </head>    
    <body>
        <nav class="navbar navbar-expand-md fixed-top bg-light navbar-light" id="navd">
            <a class="navbar-brand" href="/index.php">CheapTel.com<small class="text-muted">The best hotel prices on the web.</small></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ml-auto" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item mid">
                        <a class="nav-link text-danger" href="/index.php"><i class="fas fa-home"></i>&nbsp;Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/hotels.php"><i class="fas fa-hotel"></i>&nbsp;Hotels</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                       <?php 
                        if(isset($_SESSION["username"])) {
                            printf("<a class=\"nav-link text-danger\" href=\"/profilepage.php\"><i class=\"fas fa-user\"></i>&nbsp;".$_SESSION["username"] . "</a></li><li class=\"nav-item\"> <a class=\"nav-link text-danger\" href=\"/logout.php\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Logout</a>");
                        } else {
                            printf("<a class=\"nav-link text-danger\" href=\"/userlog.php\"><i class=\"fas fa-sign-in-alt\"></i>&nbsp;Login/Register</a>");
                        }
                        ?> 
                        
                    </li>
                </ul>
            </div>  
        </nav>
        <div id="homecarousel" class="carousel slide" data-interval="4000" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('/assets/room-1.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-2.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-3.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-4.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-5.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-6.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-7.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-8.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-9.jpg');"></div>
            <div class="carousel-item" style="background-image: url('/assets/room-10.jpg');"></div>
        </div>   
        <div class="container-fluid">    
            <div class="row">  
                <div class="vertical-center">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <form class="roomSearch" id="roomSearch" method="GET" action="hotels.php">
                        <fieldset>
                           <legend>Room Search:</legend>
                            <select class="form-control" name="city" id="city">
                                <option value="" disabled selected>City</option>
                                <?php 
                                foreach($uniqueRes as $city) {
                                        printf("<option>$city[0]</option>");
                                    }
                                
                                ?>
                            </select>             
                            <select class="form-control" name="roomtype" id="roomtype">
                                <option value="0"  selected>Room Type</option>
                                <option name="sr" value="1"><?php echo $result[0][0] ?></option>
                                <option name="dr" value="2"><?php echo $result[1][0] ?></option>
                                <option name="tr" value="3"><?php echo $result[2][0] ?></option>
                                <option name="fr" value="4"><?php echo $result[3][0] ?></option>   
                            </select>
                            
                            <input placeholder="Check-In Date" name="checkin" class="form-control" autocomplete="off" onChange ="changeDate()" type="text" id="datepicker">
                            <input placeholder="Check-Out Date" class="form-control" autocomplete="off" type="text" name="checkout" id="datepicker1" >
                            
                            <br><input type="submit" name="search" class="btn"  value="Search">
                        </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</html>