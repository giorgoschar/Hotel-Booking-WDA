<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //include "validate.php";
    include_once "dbconn.php";
    //echo "connected successfuly";
    $que = "SELECT * FROM room_type";
    $result = dbquery($que, $conn);
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
        
        <!-- Moment.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" crossorigin="anonymous"></script>
        <!--- Local Scripts --->
        <link rel="stylesheet" href="/css/styles.css">
        <link rel="stylesheet" href="/css/hotelstyles.css">
        <script src="js/script.js"></script>

    </head>    
    <body>
       
        <nav id="#navd" class="navbar sticky-top navbar-expand-md bg-light navbar-light">
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
        <div class="container">
           <h4 class="myh text-center">RESULTS</h4>
            <div class="row">
                <div class="col-sm-3">
                  <div class="collapseIcon text-left">
                  <a class="customA btn" data-toggle="collapse" href="#collapsibleSideNav" role="button" aria-expanded="false" aria-controls="collapsibleSideNav">
                    Filter Results &nbsp;<i class="fas fa-filter"></i> 
                     </a>

                     </div>
                    <nav id="collapsibleSideNav" class="collapse sidenav">
                        <p class="text-left ptitl">FILTERS</p>  
                        <form id="filterForm" class="filterForm" method="post">
                            <fieldset>   
                                <legend>Guest Count:</legend>
                                    <select class="sel1">
                                    <?php
                                        foreach($result as $uniRoomType) {
                                            if(!empty($_GET["roomtype"]) && ($_GET["roomtype"] == $uniRoomType[0])) {
                                                printf("<label><option name=\"guestcount\" selected>&nbsp; $uniRoomType[0]</label> <br>");
                                            } else {
                                                printf("<label><option name=\"guestcount\" >&nbsp; $uniRoomType[0]</label> <br>");
                                            }
                                        }
                                    ?>
                                    </select>
                            </fieldset><hr>
                            <fieldset>   
                                <legend>City:</legend>
                                <?php 
                                foreach ($uniqueRes as $uniRes) {
                                    if(!empty($_GET["city"]) && ($_GET["city"] == $uniRes[0])){
                                         printf("<label><input type=\"radio\" name=\"optradiocity\" checked>&nbsp;$uniRes[0]</label><br>");
                                       }
                                else {
                                    printf("<label><input type=\"radio\" name=\"optradiocity\" >&nbsp;$uniRes[0]</label><br>");
                                       }
                                }
                                
                                ?>
                            </fieldset><hr>
                            <fieldset>  
                                <legend>Room Type:</legend>
                                   <?php 
                                foreach($result as $uniRoomType) {
                                    if(!empty($_GET["roomtype"]) && ($_GET["roomtype"] == $uniRoomType[0])) {
                                        printf("<label><input type=\"checkbox\" name=\"roomselect\" checked>&nbsp; $uniRoomType[1]</label> <br>");
                                    } else {
                                        printf("<label><input type=\"checkbox\" name=\"roomselect\">&nbsp; $uniRoomType[1]</label> <br>");
                                    }
                            }?>
                            </fieldset><hr>
                            <fieldset>
                                    <legend>Date</legend>                                        
                                       <?php
                                            if(empty($_GET["checkin"])) {
                                                
                                                printf("<label for=\"checkin\">Check-In</label><br>
                                                 <input placeholder=\"Check-In Date\" name=\"checkin\" autocomplete=\"off\" onChange =\"changeDate()\" type=\"text\" id=\"datepicker\"><br>");
                                            } else {
                                                $checkin = $_GET["checkin"];
                                                printf("<label for=\"checkin\">Check-In</label><br>
                                                 <input value=\"$checkin\" name=\"checkin\" autocomplete=\"off\" onChange =\"changeDate()\" type=\"text\" id=\"datepicker\"><br>");
                                                
                                            }
                                          if(empty($_GET["checkout"])) {
                                                
                                                printf("<label for=\"checkout\">Check-Out</label><br>
                                                 <input placeholder=\"Check-Out Date\" name=\"checkout\" autocomplete=\"off\" type=\"text\" id=\"datepicker\"><br>");
                                            } else {
                                                $checkout = $_GET["checkout"];
                                                printf("<label for=\"checkout\">Check-Out</label><br>
                                                 <input value=\"$checkout\" name=\"checkout\" autocomplete=\"off\" type=\"text\" id=\"datepicker\"><br>");
                                                
                                            }
                                ?>
                                </fieldset><hr>
                <?php
                    $roomTypeBool = FALSE;
                    $cityBool = FALSE;
                    $checkin = $_GET['checkin'];
                    $checkout = $_GET['checkout'];
                    if(!empty($_GET["city"]) || !empty($_GET["roomtype"])) {
                            $city = $_GET["city"];
                            $roomtype = intval($_GET["roomtype"]);
                            if($roomtype > 0 && $roomtype < 5 ){
                                $roomTypeBool = TRUE;
                            } else {
                                $roomTypeBool= FALSE;
                            }
                            for ($i=0; $i<count($uniqueRes); ++$i) {
                                if($city === $uniqueRes[$i][0]) {
                                        $cityBool = TRUE;
                                }
                            }
                            
                            if($cityBool===TRUE || $roomTypeBool===TRUE) {   
                                if($roomTypeBool === FALSE) {
                                    $que2 = "SELECT * FROM room WHERE city='$city'";
                                    $results = dbquery($que2, $conn);
                                    $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city'";
                                    $maxPrice = dbquery($que3, $conn);
                                } else {
                                    $que2 = "SELECT * FROM room WHERE city='$city' AND room_type='$roomtype'";
                                    $results = dbquery($que2, $conn);  
                                    $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city' AND room_type='$roomtype'";
                                    $maxPrice = dbquery($que3, $conn);
                                }
//                                $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city' AND room_type='$roomtype'";
//                                $maxPrice = dbquery($que3, $conn);
//                            }elseif($cityBool===TRUE && $roomTypeBool===FALSE) {
//                                $que3 = "SELECT MAX(price) AS maxPrice FROM room";
//                                $maxPrice = dbquery($que3, $conn);
//                                $que4 = "SELECT * FROM room WHERE city=$city";
//                                $results = dbquery($que4,$conn);
                            } else {
                             $que3 = "SELECT MAX(price) AS maxPrice FROM room";
                                $maxPrice = dbquery($que3, $conn);   
                            } 
                        
                    } else {
                                $que3 = "SELECT MAX(price) AS maxPrice FROM room";
                                $maxPrice = dbquery($que3, $conn);
                                $que4 = "SELECT * FROM room";
                                $results = dbquery($que4,$conn);
                        }
                        ?>
                                    <fieldset>
                                    <legend>Price</legend>
                                            <p class="inline-block text-right p1"><span  id="priceVal"></span>€&nbsp;</p>
                                            <input type="range" class="priceRange custom-range" id="priceRange" value=""     name="price" min="0" max="<?php echo $maxPrice[0][0]; ?>">
                                    </fieldset> 
                                </form>
                            </nav>
                        </div>
                        <div class="col-sm-9">
                        <?php
                            if(!empty($results)) {
                                foreach ($results as $res) {
                                printf("                    
                                    <div class='card flex-row flex-wrap'>
                                        <div class='card-header cheader'>
                                            <img class='card-img-right img' src='/assets/$res[4]'  alt='$res[4]'>
                                            "); 
                                                switch ($res[13]){
                                                    case 1:
                                                        $hasWifi = "<i class=\"fas fa-wifi\"></i>";
                                                        break;
                                                    case 0:
                                                        $hasWifi = "";
                                                        break;
                                                };
                                                 switch ($res[14]){
                                                    case 1:
                                                        $hasParking = "<i class=\"fas fa-parking\"></i>";
                                                        break;
                                                    case 0:
                                                        $hasParking = "";
                                                        break;
                                                 };
                                                switch ($res[13]){
                                                    case 1:
                                                        $receivesPets = "<i class=\"fas fa-paw\"></i>";
                                                        break;
                                                    case 0:
                                                        $receivesPets = "";
                                                        break;
                                                };

                                        printf("
                                        </div>
                                        <div class='card-block cbody'>
                                        <h5 class='card-title'>$res[1]</h5>
                                        <p class='card-text'>$hasWifi &nbsp; $hasParking &nbsp; $receivesPets</p>
                                        <p class='card-text p3'>Price: $res[7]€</p>
                                        <p class='card-text p3'>Area: <a class='customB' data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Click me for Google Maps location\" href='https://www.google.com/maps/@$res[9],$res[10],18.75' target='_blank'>$res[8]</a>, $res[3]</p>
                                    </div>
                                    <div class=\"card-footer w-100\">
                                        <a class=\"customC\" href=\"learnmore.php?hname=$res[1]&checkin=$checkin&checkout=$checkout\">Learn More</a>
                                    </div>
                                </div>
                                <br><br>"
                                );

                        }
                                
                            } else {
                                ?> <p>Results not found</p>
                                <?php
                            }
                         ?>
                        </div>
                    </div>
                </div>
</html>