<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    if(isset($_SESSION["userid"])){
        ?>  <script>
                var userid = <?php echo $_SESSION["userid"];?>;
            </script>

        <?php
    }else {
        
        ?>
        
        <script>
            var userid = 0;
        </script>
        <?php
    }
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
        <link rel="stylesheet" href="/css/learnmorestyles.css">
        <script>
            <?php 
            //if userid and username are set then create a variable user id for javascript to use in AJAX
                if(isset($_SESSION["userid"]) && isset($_SESSION["username"])) { ?>
                   var userid = <?php echo $_SESSION["userid"];?>;
            <?php
                } else { ?>
                    var userid=0;
            <?php 
                } 
            ?>
        </script>
        <script src="js/script.js" async defer ></script>
        <script src="js/learnmore.js"></script>

        <style>
            /*styling for google maps*/
          #map {
            height:50% !important;
            margin-top:2% !important;
            width: 100% !important;    
           }
        </style>
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
                    <div  id="username">
                        <?php 
                            if(isset($_SESSION["username"])) {
                                printf("<li class=\"nav-item\"><a class=\"nav-link text-danger\" href=\"/profilepage.php\"><i class=\"fas fa-user\"></i>&nbsp;".$_SESSION["username"] . "</a></li><li class=\"nav-item\"> <a class=\"nav-link text-danger\" href=\"/logout.php?page=learnmore.php\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Logout</a></li>");
                            } else {
                                printf("<a class=\"nav-link text-danger\" data-toggle=\"modal\" data-target=\"#loginModal\"><i class=\"fas fa-sign-in-alt\"></i>&nbsp;Login/Register</a></li>");
                            }
                        ?>
                    </div> 
                </ul>
            </div>  
        </nav>
        <div class="container">
            <div class="row">
                <div class="title col-sm-8">
                    <?php 
                        //Validating that user came with a hotel name and that the hotel name exists on the database
                        $hnameBool = TRUE;
                        if(empty($_GET["hname"])){
                           $hnameBool=FALSE;
                        } else { 
                            $quer = "SELECT name FROM room";
                            $hotelnames = dbquery($quer,$conn);
                            foreach ($hotelnames as $hotelname) { 
                                if ($hotelname[0] === $_GET["hname"]) {
                                    $hnameBool = TRUE;
                                    break;
                                } else { 
                                    $hnameBool = FALSE;
                                }
                            }
                        }
                        //getting Hotel Name from the link and printing on the title as well as getting all info on the room.
                        if($hnameBool === TRUE){
                            if(empty($_SESSION["username"])) {
                                include_once "login_register.php";
                            }
                            $hname = mysqli_real_escape_string($conn,$_GET["hname"]);
                            
                            $que = "SELECT * FROM room WHERE name='$hname'";
                            $hoteldesc = dbquery($que,$conn);
                            ?>
                                <script>
                                   var hotelID = "<?php echo $hoteldesc[0][0]; ?>";
                                </script>
                        <div class="titleText">
                            <p class="p1 cap" id="p1"><?php echo $hname;?></p><p class="p1" id="p1">&nbsp; |&nbsp; <?php echo $hoteldesc[0][2];?>,&nbsp;<?php echo $hoteldesc[0][3];?> |   Reviews:
                            <?php
                                //getting average review and printing the corresponding stars.
                                $que2="SELECT AVG(rate) FROM reviews WHERE room_id=" . $hoteldesc[0][0];
                                $reviews = dbquery($que2, $conn);
                                $avgrev = $reviews[0][0];
                            ?>
                            <?php 
                                $whole = floor($avgrev);
                            //echo $wholeRes;
                                $decRes = $avgrev - $whole;
                                if($decRes > 0.5) {
                                    for($i=0;$i<$whole;$i++) {
                                        printf("<i class=\"fas fa-star checked\"></i>");                            
                                    }
                                    printf("<i class=\"fas fa-star-half-alt checked\"></i>");
                                    $whole = $whole + 1;
                                } else {
                                    for($i=0;$i<$whole;$i++) {
                                        printf("<i class=\"fas fa-star checked\"></i>");                            
                                    }
                                }
                                
                                $notChecked = 5 - $whole;
                                //echo $notChecked;
                                if($notChecked !== 0){
                                    //echo "whole:" . $whole;
                                        for($i=0;$i<$notChecked;++$i) {
                                            printf("<i class=\"notChecked far fa-star\"></i>");
                                        }
                                        }
                                if(isset($_SESSION["userid"]) && $_SESSION["userid"] !== "0") {
                                    $favs= "SELECT favorites.status FROM favorites WHERE user_id=" . $_SESSION['userid'] . " AND room_id= ". $hoteldesc[0][0];
                                    $favorites= dbquery($favs,  $conn);
                            ?> 
                            </p>
                            <div class="p1" id="favorites"> 
                                <?php 
                                    if (!empty($favorites) && $favorites[0][0] == 1) {
                                        printf("| <p class='heart'> &nbsp;<i class='fas fa-heart' onclick='addToFavorites()' style='color:orange'></i></p>");
                                    } else { 
                                        printf("| <p class='heart'>  &nbsp;<i class='far fa-heart ' onclick='addToFavorites()' style='color:orange'></i></p>");
                                    }
                                } else { 
                                    printf("| <p class='heart'>&nbsp;<i class='far fa-heart' onclick='addToFavorites()' style='color:orange'></i></p>");
                                }
                            
                            
                                ?>
                            </div>
                            <div id="priceTitle" class="priceTitle">
                                <p class="p1">Per Night: <?php echo $hoteldesc[0][7];?>€ </p>
                            </div>
                        </div>
                </div>
                <!-- Printing Room Info -->
                <div class="image col-sm-12">
                    <img class="imagesrc" src="assets/<?php echo $hoteldesc[0][4]?>" alt="Hotel Room Photo">
                </div>
                <div class="info col-sm-8" id="info">
                        <div class="p2" id="p2">
                             <p class="text-center p5"><i class="fas fa-user text-center"></i>&nbsp;<?php echo $hoteldesc[0][6]?><br>COUNT OF GUESTS</p>
                         </div>
                         <div class="p2" id="p2">
                             <p class="text-center p5"><i class="fas fa-bed text-center"></i>&nbsp;<?php echo $hoteldesc[0][5]?><br>TYPE OF ROOM</p>
                         </div>
                         <div class="p2" id="p2">
                             <p class="text-center p5"><i class="fas fa-parking text-center"></i>&nbsp;<?php echo $hoteldesc[0][13]?><BR>PARKING</p>
                         </div>
                         <div class="p2" id="p2">
                             <p class="text-center p5"><i class="fas fa-wifi text-center"></i>&nbsp;<?php if($hoteldesc[0][14]==1){ echo "Yes";} else { echo "No"; }?><BR>WI-FI</p>
                         </div>
                         <div class="p3 flex-fill" id="p3">
                             <p class="text-center p5"><i class="fas fa-paw text-center"></i>&nbsp;<?php if($hoteldesc[0][15]==1){ echo "Yes";} else { echo "No"; }?><BR>PET FRIENDLY</p>
                         </div>
                </div>
                <div class="desc col-sm-12">
                    <h4 class="addCol">Room Description</h4>
                    <p class="p4"><?php echo $hoteldesc[0][12]?></p>
                </div>
                <div class="booknow col-sm-12">
                    <?php 
                        //Checking Date Validation (using PHP checkdate()) and printing the correct availability and corresponding button.
                        $bookingque = "SELECT bookings.* FROM bookings INNER JOIN user on bookings.user_id=user.user_id WHERE room_id=".$hoteldesc[0][0];
                        $bookingsql = dbquery($bookingque, $conn);
                        if(!empty($_GET["checkin"] && !empty(($_GET["checkout"])))){
                            $checkinDate = $_GET["checkin"];
                            $checkoutDate = $_GET["checkout"];
                            //Validate Dates:
                            $checkinDateArr = explode('-',$checkinDate);
                            $checkoutDateArr = explode('-',$checkoutDate);
                            $checkDateBool =FALSE;
                            if(count($checkinDateArr) == 3 && count($checkoutDateArr) == 3) {
                                if(checkdate($checkinDateArr[1],$checkinDateArr[2], $checkinDateArr[0]) && checkdate($checkoutDateArr[1],$checkoutDateArr[2],$checkoutDateArr[0])) {
                                    $indate = strtotime($checkinDate);
                                    $outdate = strtotime($checkoutDate);
                                    for($i=0;$i<count($bookingsql);$i++) {
                                        $bookedindate = strtotime($bookingsql[$i][1]);
                                        $bookedoutdate = strtotime($bookingsql[$i][2]);
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
                                if($checkDateBool == TRUE) {
                                    ?>
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Select Dates to Book</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                              <div class="form">
                                                <input placeholder="Check-In Date" name="checkin" class="form-control" autocomplete="off" onChange ="changeDate()" type="text" id="datepicker" required>
                                                <input placeholder="Check-Out Date" class="form-control" autocomplete="off" type="text" name="checkout" id="datepicker1" required>
                                                <input type="hidden" type="text" id="room_id" value="<?php echo $hoteldesc[0][0];?>">
                                                <!-- <input type="hidden" type="text" name="user_id" value="<?php if(isset($_SESSION["userid"])) {echo $_SESSION["userid"];} else {echo "0";}?>"> -->
                                                <div class="modal-footer">
                                                <button type="submit" id="btn-submit" value="" class="form-control">Book Now</button>
                                                </div>
                                             </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="error-container"></div>
                                    <div id="error-container-old">
                                        <div class="alert alert-danger">
                                            <strong>Not Available</strong> The hotel you are currently watching is not free for booking in the dates you are looking for.
                                        </div>
                                    </div>
                                    
                                    <button style="background-color:transparent;" data-toggle="modal" data-target="#myModal" value="Book Now" id="myModalBtn" class="customC float-right" error>Click to Select New Dates</button>
                                    <?php
                                } else { 
                                    ?>
                                    <div class="alert alert-info">
                                      <strong>Available</strong> The hotel you are currently watching is free for booking in the dates you are looking for.
                                    </div>
                                    <div class="form">
                                        <input type="hidden" type="text" id="room_id" value="<?php echo $hoteldesc[0][0]?>">
                                        <!-- <input type="hidden" type="text" name="user_id" value=""> -->
                                        <input type="hidden" type="text" id="datepicker" value="<?php echo $checkinDate;?>">
                                        <input type="hidden" type="text" id="datepicker1" value="<?php echo $checkoutDate?>">
                                        <button type="submit" id="btn-submit" name="btn-submit" style="background-color:transparent;" class="customC">Book Now</button>
                                     </div>
                                     <?php
                                
                                        }
                                                                                        }
                                                                                            }
                  
                        }else {
                            
                            ?>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Select Dates to Book</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                              <div class="form">
                                                <input placeholder="Check-In Date" name="checkin" class="form-control" autocomplete="off" onChange ="changeDate()" type="text" id="datepicker" required>
                                                <input placeholder="Check-Out Date" class="form-control" autocomplete="off" type="text" name="checkout" id="datepicker1" required>
                                                <input type="hidden" type="text" id="room_id" value="<?php echo $hoteldesc[0][0];?>">
                                                <!-- <input type="hidden" type="text" name="user_id" value="<?php if(isset($_SESSION["userid"])) {echo $_SESSION["userid"];} else {echo "0";}?>"> -->
                                                <div class="modal-footer">
                                                <button type="submit" id="btn-submit" value="" class="form-control">Book Now</button>
                                                </div>
                                             </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="error-container"></div> 
                            <button style="background-color:transparent;" data-toggle="modal" data-target="#myModal" name="submit" value="Book Now" id="myModalBtn" class="customC">Select Dates</button>  
                    <?php
                        } 
                        
                    ?>
                </div>
                <!-- Google Maps -->
                <div class="col-sm-12" id="map">
                        <script>
                          function initMap() {
                            <?php $lat = $hoteldesc[0][9];
                              $lng = $hoteldesc[0][10];
                              ?>
                              var long = <?php echo $lng?>;
                              var lati = <?php echo $lat?>;
                            var myLatLng = {lat: lati , lng: long};

                            var map = new google.maps.Map(document.getElementById('map'), {
                              zoom: 18,
                              center: myLatLng
                            });

                            var marker = new google.maps.Marker({
                              position: myLatLng,
                              map: map,
                              
                            });
                          }
                          </script>
                </div>
                <!-- Printing each review for this room -->
                <div class="col-sm-12 reviews" id="reviews">
                    <h4 class="addCol">Reviews</h4>
                    <div id="reviewcontainer">
                    <?php 
                        $roomid=$hoteldesc[0][0];
                        $que3="SELECT reviews.*, user.username FROM reviews INNER JOIN user  on reviews.user_id = user.user_id WHERE reviews.room_id=$roomid  ORDER BY reviews.rate DESC";
                        $reviews= dbquery($que3,$conn);
                        //var_dump($reviews);
                        if(empty($reviews)){
                            printf("No Reviews Found");
                        }else {
                            $t=1;
                        foreach ($reviews as $review) {
                            printf("<span>$t." . $review[6]."&nbsp;<span>");
                            for($i=1;$i<=$review[1];$i++) {
                                printf("<i class=\"fas fa-star checked\"></i>");
                                
                            }
                            $notChecked = 5 - $review[1];
                            if($notChecked !== 0){
                            for($i=1;$i<=$notChecked;++$i) {
                                printf("<i class=\"notChecked far fa-star\"></i>");
                            }
                                
                            }
                            printf("<br><p class=\"reviewdescsm\"><em>Time Added: $review[3]</em></p>");
                            printf("<p class=\"reviewdesc\">$review[2]</p>");
                            $t= $t + 1;
                        }
                    }              
                    ?>
                    </div>
                    <!-- Add Review Form -->
                    <div class="col-sm-12 addReview" >
                        <h4 class="addCol">Add Review</h4>
                        <ul id="error"><li id="form-message"></li></ul>
                        <div class="addReviewForm" id="ratingform">
                            <div class="rating">
                                <label>
                                    <input type="radio" name="stars" onclick="getRate(this.id)" id="s1" value="1" />
                                    <span class="icon">★</span>
                                </label>
                                <label>
                                    <input type="radio" name="stars" id="s2" onclick="getRate(this.id)" value="2" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                </label>
                                <label>
                                    <input type="radio" name="stars" id="s3" onclick="getRate(this.id)" value="3" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>   
                                </label>
                                <label>
                                    <input type="radio" name="stars" id="s4" onclick="getRate(this.id)" value="4" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                </label>
                                <label>
                                    <input type="radio" name="stars" id="s5" onclick="getRate(this.id)"  value="5" />
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                    <span class="icon">★</span>
                                </label>
                            </div>
                            <input type="hidden" id="starrating" name="starrating" value="">
                            <input type="hidden" id="roomid" name="roomid" value="<?php echo $roomid?>">
                            <input type="textarea" class="ta" id="ta" name="reviewText" placeholder="Review Comments">
                            <button type="submit"  class="customD" id="btn1-submit">Add Review</button>
                        </div>
                    </div>
                </div>
                <?php
                    } else {
                        header('Location:404.html');                        
                    }
                ?>
            </div>
        </div>
        <footer class="footer">
            <div class="col-sm-12">
                <Hr class="style-two">
                <p class="text-center" style="color:#dc3545;">Coded by George Charitidis</p>
            </div>
        </footer>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
        </script>
        <div class="modal fade" id="modalbooked" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalbookedLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p>You successfully booked this hotel. It will now appear in your profile page!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>