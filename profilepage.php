<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    if(!isset($_SESSION["username"])) {
        header("location:userlog.php?page=profile");
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

        <style>
          #map {
            min-height:50vh;
            width: 80%;  
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
            <div class="row row1">
               <div class="reviews col-sm-2">
                   <h3 class="myfh3 text-center">REVIEWS</h3>
                   <Hr class="style-two">
                    <?php 
                        $que = "SELECT reviews.rate, room.name FROM reviews INNER JOIN user on reviews.user_id=user.user_id INNER JOIN room on reviews.room_id=room.room_id WHERE reviews.user_id=" . $_SESSION["userid"];  
                        $reviews = dbquery($que, $conn);
                        //var_dump($reviews);
                        if(empty($reviews)){
                            printf("No Reviews Found");
                        }else {
                            ?> <div class="stars"> <?php
                            $num=0;
                            foreach ($reviews as $review) {
                                $num +=1;
                                printf("<h5 class=\"my4\">$num. $review[1]<h5>");
                                
                                for($i=1;$i<=$review[0];$i++) {
                                    printf("<i class=\"fas fa-star checked\"></i>");
                                    //$checked+=1;

                                }
                                //echo $checked;
                                //echo $review[1];
                                $notChecked = 5 - $review[0];
                                //echo $notChecked;
                                if($notChecked !== 0){
                                for($i=1;$i<=$notChecked;++$i) {
                                    printf("<i class=\"notChecked far fa-star\"></i>");
                                }

                                }
                        }
                        }
                   
                    ?>
                    </div>
                </div>
                <div class="book col-sm-10">
                    <h4 class="myh3 text-left">My Bookings</h4>
                
                    <?php 
                    $que1 = "SELECT bookings.check_in_date, bookings.check_out_date, room.name, room.city, room.area, room.photo, room.room_type, room.price, room.wifi, room.parking, room.pet_friendly, room_type.room_type FROM bookings INNER JOIN room on bookings.room_id=room.room_id INNER JOIN room_type on room.room_type=room_type.id WHERE bookings.user_id=" . $_SESSION["userid"];
                    $results = dbquery($que1,$conn);
                    if(!empty($results)) {
                        foreach ($results as $res) {
                            ?>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class='card flex-row flex-wrap'>
                                                <div class='card-header cheader'>
                                                    <img class='card-img-right img' src="/assets/<?php echo $res["photo"]?>"  alt="<?php echo $res["photo"]?>"> 
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
                                                
                                                </div>
                                                <div class='card-block cbody'>
                                                <h5 class='card-title'><?php echo  $res["name"]?></h5>
                                                <p class='card-text'><?php echo $hasWifi ?> &nbsp; <?php echo $hasParking ?> &nbsp; <?php echo  $receivesPets?></p>
                                                <p class='card-text p3'>Price: <?php echo $res[7]?>€</p>
                                                <p class='card-text p3'>Area: <?php echo $res["area"] ?>
                                            </div>
                                            <div class="card-footer w-100">
                                                <p class="date"><span>Check-In Date:&nbsp;</span><?php echo $res["check_in_date"];?>&nbsp;|</p>
                                                <p class="date"><span>Check-Out Date:&nbsp;</span><?php echo $res["check_out_date"];?>&nbsp;|</p>
                                                <p class="tor"><span>Type of Room: &nbsp;</span><?php echo $res["room_type"];?></p>
                                                <a class="customC" href="learnmore.php?hname=<?php echo $res["name"]?>&checkin=<?php echo $res["check_in_date"]?>&checkout=<?php echo $res["check_out_date"]?>">Learn More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                              <?php  

                        } 
                    } else {
                    ?>
                        <p>Results Not Found</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <footer class="footer">
               <div class="col-sm-12">
               <Hr class="style-two">
                <p class="text-center" style="color:#dc3545;">Coded by George Charitidis</p>
                </div>
            </footer>
    </body>
</html>