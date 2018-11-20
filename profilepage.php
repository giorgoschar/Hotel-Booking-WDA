<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    if(!isset($_SESSION["username"])) {
        header("location:index.php?page=profile");
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
        <!-- Moment.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" crossorigin="anonymous"></script>
        <!--- Local Scripts --->
        <link rel="stylesheet" href="/css/styles.css">
        <link rel="stylesheet" href="/css/profilepagestyles.css">
        <script src="js/profilepage.js" async defer></script>
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
                                printf("<li class=\"nav-item\"><a class=\"nav-link text-danger\" href=\"/profilepage.php\"><i class=\"fas fa-user\"></i>&nbsp;".$_SESSION["username"] . "</a></li><li class=\"nav-item\"> <a class=\"nav-link text-danger\" href=\"/logout.php?page=index.php\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Logout</a></li>");
                            } else {
                                printf("<a class=\"nav-link text-danger\" data-toggle=\"modal\" data-target=\"#loginModal\"><i class=\"fas fa-sign-in-alt\"></i>&nbsp;Login/Register</a></li>");
                            }
                        ?>
                    </div> 
                </ul>
            </div>  
        </nav>
        <div class="container">
            <div class="row row1">
               <div class="reviews col-sm-2">
                   <h5 class="myfh3 text-left">REVIEWS</h5>
                   <Hr class="style-two">
                   <?php 
                        $que = "SELECT reviews.rate, room.name FROM reviews INNER JOIN user on reviews.user_id=user.user_id INNER JOIN room on reviews.room_id=room.room_id WHERE reviews.user_id=" . $_SESSION["userid"];  
                        $reviews = dbquery($que, $conn);
                        //var_dump($reviews);
                        if(empty($reviews)){
                            printf("<p>No Reviews Found</p>");
                        } else {
                            ?> <div class="stars"> <?php
                            $num=0;
                            foreach ($reviews as $review) {
                                $num +=1;
                                printf("<h6 class=\"my4\">$num. $review[1]<h6>");
                                
                                for($i=1;$i<=$review[0];$i++) {
                                    printf("<i class=\"fas fa-star checked\"></i>");
                                }
                                $notChecked = 5 - $review[0];
                                if($notChecked !== 0){
                                for($i=1;$i<=$notChecked;++$i) {
                                    printf("<i class=\"notChecked far fa-star\"></i>");
                                }

                                }
                            }
                            ?> </div> <?php
                        }
                    ?>
                   <h5 class="myfh4 text-left">FAVORITES</h5>
                   <Hr class="style-two">
                   <?php 
                        $que2 = "SELECT favorites.status, room.name FROM favorites INNER JOIN room on favorites.room_id=room.room_id WHERE favorites.user_id=" . $_SESSION["userid"];  
                        $favorites = dbquery($que2, $conn);
                        if(empty($favorites)){
                            printf("<p>No Favorites Found</p>");
                        } else {
                            $num2=0;
                            foreach ($favorites as $favorite) {
                                if($favorite["status"] == 1) {
                                    $num2+=1;
                                    ?> 
                                    <h6 class="my4"><?php echo "<p class='my4'><i  class='fas fa-heart' onclick='addToFavorites()' style='color:orange'></i>&nbsp;</p>" .$favorite["name"];?></h6><br>
                                    <?php
                                } else {
                                    printf("<p>No Favorites Found</p>");
                                }
                            }
                        }


                    ?>
            </div>
            <div class="book col-sm-10">
                <h5 class="myh3 text-center">MY BOOKINGS</h5>
                <hr class="style-two">
                <div id="bookings">
                    <?php 
                        $que1 = "SELECT bookings.check_in_date, bookings.check_out_date, bookings.booking_id, room.name, room.city, room.area, room.photo, room.room_type, room.price, room.wifi, room.parking, room.pet_friendly, room_type.room_type FROM bookings INNER JOIN room on bookings.room_id=room.room_id INNER JOIN room_type on room.room_type=room_type.id WHERE bookings.user_id=" . $_SESSION["userid"];
                        $results = dbquery($que1,$conn);
                        if(!empty($results)) {
                            foreach ($results as $res) {
                                ?>
                                <div class="row">
                                    <div class="col-sm-10 align-self-center info-card">
                                        <?php 
                                            switch ($res["wifi"]){
                                                case 1:
                                                    $hasWifi = '<i class="fas fa-wifi"></i>';
                                                    break;
                                                case 0:
                                                    $hasWifi = "";
                                                    break;
                                            };
                                            switch ($res["parking"]){
                                                case 1:
                                                    $hasParking = '<i class="fas fa-parking"></i>';
                                                    break;
                                                case 0:
                                                    $hasParking = "";
                                                    break;
                                            };
                                            switch ($res["pet_friendly"]){
                                                case 1:
                                                    $receivesPets = '<i class="fas fa-paw"></i>';
                                                    break;
                                                case 0:
                                                    $receivesPets = "";
                                                    break;
                                            };
                                        ?>
                                        <div class="front">
                                            <img class="card-image" src="/assets/<?php echo $res["photo"]?>"  alt="<?php echo $res["photo"]?>">
                                            <div class="centered text-center text-uppercase">
                                                <?php echo $res["name"];?>
                                            </div>
                                        </div> 
                                        <div class="description back">
                                            <h5 class='hname text-uppercase text-center'><?php echo  $res["name"]?></h5>
                                            <hr class="style-two">
                                            <p class='text-center'><?php echo $hasWifi ?> &nbsp; <?php echo $hasParking ?> &nbsp; <?php echo  $receivesPets?></p>
                                            <p class='p3 text-center'><?php echo $res["city"] ?>
                                            <p class='p3 text-center'><i class="fas fa-thumbtack"></i> <?php echo $res["area"] ?>
                                            <div class="footer">
                                                <p class='price'>Per Night: <?php echo $res["price"]?>€</p>
                                                <div class="dates">
                                                    <p class="date"><span>Check-In Date:&nbsp;</span><?php echo $res["check_in_date"];?>&nbsp;|</p>
                                                    <p class="date"><span>Check-Out Date:&nbsp;</span><?php echo $res["check_out_date"];?>&nbsp;|</p>
                                                    <p class="date"><span>Type of Room: &nbsp;</span><?php echo $res["room_type"];?></p>
                                                    <a class="customC2" href="learnmore.php?hname=<?php echo $res["name"]?>&checkin=<?php echo $res["check_in_date"]?>&checkout=<?php echo $res["check_out_date"]?>">Learn More</a>
                                                    <input type="hidden" id="bookingid<?php echo $res["booking_id"]?>" value="<?php echo $res["booking_id"]?>">
                                                    <button class="customC" type="submit" id="btn-submit<?php echo $res["booking_id"]?>" onclick="deleteRecord(this.id);">Cancel Booking</button>
                                                </div>
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
        <footer class="footer">
            <div class="col-sm-12">
                <Hr class="style-two">
                <p class="text-center" style="color:#dc3545;">Coded by George Charitidis</p>
            </div>
        </footer>
        <div class="modal fade" id="modalCanceled" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCanceledLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Your booking was canceled successfully
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>