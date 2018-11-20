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
        <link rel="stylesheet" href="/css/hotelstyles.css">
        <script src="/js/hotelscript.js"></script>
        <script src="js/script.js"></script>

    </head>    
    <body>
       <?php 
        if(empty($_SESSION["username"])) {
            include_once "login_register.php";
        }
        ?>
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
                    <div  id="username">
                        <?php 
                            if(isset($_SESSION["username"])) {
                                printf("<li class=\"nav-item\"><a class=\"nav-link text-danger\" href=\"/profilepage.php\"><i class=\"fas fa-user\"></i>&nbsp;".$_SESSION["username"] . "</a></li><li class=\"nav-item\"> <a class=\"nav-link text-danger\" href=\"/logout.php?page=hotels.php\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Logout</a></li>");
                            } else {
                                printf("<a class=\"nav-link text-danger\" data-toggle=\"modal\" data-target=\"#loginModal\"><i class=\"fas fa-sign-in-alt\"></i>&nbsp;Login/Register</a></li>");
                            }
                        ?>
                    </div> 
                </ul>
            </div>  
        </nav>
        <div class="container myh">
            <div class="row">
                <div class="col-sm-3">
                    <div class="collapseIcon text-left">
                        <a class="customA" data-toggle="collapse" href="#collapsibleSideNav" role="button" aria-expanded="false" aria-controls="collapsibleSideNav">
                        Filter Results &nbsp;<i class="fas fa-filter"></i></a>

                    </div>
                    <nav id="collapsibleSideNav" class="collapse sidenav">
                        <p class="text-left ptitl">FILTERS</p>  
                        <form id="filterForm" class="filterForm" method="post">
                            <fieldset>   
                                <legend>City:</legend>
                                    <?php 
                                        foreach ($uniqueRes as $uniRes) {
                                            if(!empty($_GET["city"]) && ($_GET["city"] == $uniRes[0])){
                                                printf("<label><input type=\"radio\" class=\"radiocity\" name=\"optradiocity\" value=\"$uniRes[0]\"checked>&nbsp;$uniRes[0]</label><br>");
                                            }
                                            else {
                                            printf("<label><input type=\"radio\" class=\"radiocity\"  name=\"optradiocity\" value=\"$uniRes[0]\" >&nbsp;$uniRes[0]</label><br>");
                                            }
                                        }
                                    ?>
                            </fieldset>
                            <hr>
                            <fieldset>  
                                <legend>Room Type:</legend>
                                    <?php 
                                        foreach($result as $uniRoomType) {
                                            if(!empty($_GET["roomtype"]) && ($_GET["roomtype"] == $uniRoomType[0])) {
                                                printf("<label><input type=\"checkbox\" class=\"roomselect\" name=\"roomselect\" value=\"$uniRoomType[0]\" checked>&nbsp; $uniRoomType[1]</label> <br>");
                                            } else {
                                                printf("<label><input type=\"checkbox\" class=\"roomselect\" name=\"roomselect\" value=\"$uniRoomType[0]\">&nbsp; $uniRoomType[1]</label> <br>");
                                            }
                                        }
                                    ?>
                            </fieldset>
                            <hr>
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
                                            <input placeholder=\"Check-Out Date\" name=\"checkout\" autocomplete=\"off\" type=\"text\" id=\"datepicker1\"><br>");
                                        } else {
                                            $checkout = $_GET["checkout"];
                                            printf("<label for=\"checkout\">Check-Out</label><br>
                                            <input value=\"$checkout\" name=\"checkout\" autocomplete=\"off\" type=\"text\" id=\"datepicker1\"><br>");

                                        }
                                    ?>
                            </fieldset>
                            <hr>
                            <?php
                                if(isset($_GET["checkin"]) && !empty($_GET["checkin"]) && isset($_GET["checkout"]) && !empty($_GET["checkout"])){
                                    $checkin = mysqli_real_escape_string($conn,$_GET['checkin']);
                                    $checkout = mysqli_real_escape_string($conn,$_GET['checkout']);
                                } else {
                                    $checkin = "";
                                    $checkout = "";
                                }
                                if(isset($_GET["city"]) && !empty($_GET["city"])) {
                                    $city = mysqli_real_escape_string($conn,$_GET["city"]);
                                } else {
                                    $city = "";
                                }
                                if(isset($_GET["roomtype"]) && !empty($_GET["roomtype"])) {
                                    $roomtype = intval(mysqli_real_escape_string($conn,$_GET["roomtype"]));
                                } else { 
                                    $roomtype = 0;
                                } 
                                if(!empty($city)) {
                                    if($roomtype == 0) {
                                        $que2 = "SELECT * FROM room WHERE city='$city'";
                                        $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city'";
                                    } elseif ($roomtype > 0 && $roomtype < 5) {
                                        $que2 = "SELECT * FROM room WHERE city='$city' AND room_type='$roomtype'";
                                        $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city' AND room_type='$roomtype'";
                                    }      
                                } else {
                                        $que3 = "SELECT MAX(price) AS maxPrice FROM room";
                                        $que2 = "SELECT * FROM room";
                                        }
                                        $results = dbquery($que2,$conn);
                                        $maxPrice = dbquery($que3, $conn);
                                        //var_dump($results);
                                        $maxPriceDis = intval($maxPrice[0][0])+1;
                            ?>
                            <fieldset>
                                <legend>Price</legend>
                                    <p class="inline-block text-right p1"><span id="priceVal"></span>€&nbsp;</p>
                                    <input type="range" class="priceRange custom-range" id="priceRange" value="0"     name="price" min="0" max="<?php echo $maxPriceDis; ?>">
                            </fieldset> 
                        </form>
                    </nav>
                </div>
                <div class="col-sm-9">
                    <h4 class="text-center htitl">RESULTS</h4>
                    <div id="resultsPrinted">
                        <?php
                            if(!empty($results)) {
                                $checkDateBool = FALSE;
                                foreach ($results as $res) {
                                    $checkDateBool = FALSE;
                                    $bookingque = "SELECT bookings.check_in_date, bookings.check_out_date FROM bookings WHERE room_id=".$res[0];
                                    $bookingsql = dbquery($bookingque, $conn);
                                    if($checkin !== "" && $checkout !== "") {
                                        $indate = strtotime($checkin);
                                        $outdate = strtotime($checkout);
                                        foreach ($bookingsql as $booking) {
                                            $bookedindate= strtotime($booking[0]);
                                            $bookedoutdate = strtotime($booking[1]);
                                            if($indate == $bookedindate || $outdate == $bookedoutdate) {
                                                $checkDateBool =TRUE;
                                                break;
                                            }
                                            if($indate >= $bookedindate && $indate <= $bookedoutdate) {
                                                $checkDateBool = TRUE;
                                                break;
                                            }
                                            if($outdate >= $bookedindate && $outdate<=$bookedoutdate) {
                                                $checkDateBool = TRUE;
                                                break;
                                            }
                                        }
                                    }
                                    if($checkDateBool == FALSE) {
                                        $availability = "<span class=\"alert alert-success availability\">Available</span>";
                                    } else {
                                        $availability = "<span class=\"alert alert-danger availability\">Not Available</span>";

                                    }


                                    ?>                   
                                    <div class="align-self-center info-card">
                                        <?php 
                                            switch ($res["wifi"]){
                                                case 1:
                                                    $hasWifi = '<i class="fas fa-wifi"></i>';
                                                    break;
                                                case 0:
                                                    $hasWifi = '<i style="color:lightgray;"class="fas fa-wifi"></i>';
                                                    break;
                                            };

                                            switch ($res["parking"]){
                                                case 1:
                                                    $hasParking = '<i class="fas fa-parking"></i>';
                                                    break;
                                                case 0:
                                                    $hasParking = '<i style="color:lightgray;"class="fas fa-parking"></i>';
                                                    break;
                                            };

                                            switch ($res["pet_friendly"]){
                                                case 1:
                                                    $receivesPets = '<i class="fas fa-paw"></i>';
                                                    break;
                                                case 0:
                                                    $receivesPets = '<i style="color:lightgray;"class="fas fa-paw"></i>';
                                                    break;
                                            };
                                        ?>
                                        <div class="front">
                                            <img class="card-image" src="/assets/<?php echo $res["photo"];?>"  alt="<?php echo $res["photo"];?>">
                                            <div class="centered text-center text-uppercase" id="centered">
                                                <?php echo $res["name"];?>
                                            </div>
                                        </div> 
                                        <div class="description back">
                                            <h5 class='hname text-uppercase text-center'><?php echo  $res["name"];?></h5>
                                            <hr class="style-two">
                                            <p class='text-center'><?php echo $hasWifi; ?> &nbsp; <?php echo $hasParking; ?> &nbsp; <?php echo  $receivesPets;?></p>
                                            <p class='p3 text-center'><?php echo $res["city"];?>
                                            <p class='p3 text-center'><i class="fas fa-thumbtack"></i> <?php echo $res["area"]; ?>
                                            <div class="footer">
                                                <p class='price'>Per Night: <strong><?php echo $res["price"];?></strong>€</p>
                                                <div class="dates">
                                                    <a class="customC" href="learnmore.php?hname=<?php echo $res["name"];?>&checkin=<?php echo $checkin;?>&checkout=<?php echo $checkout;?>">Learn More</a>
                                                    <a class="availability" ?><?php echo $availability;?></a>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>            
                                    <?php
                                }

                            } else {
                            ?> 
                                <div class="alert alert-danger resnotfound text-uppercase">Results not found</div>
                            <?php
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>