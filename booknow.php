<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    
    if(isset($_POST["submit"])) {
            $checkin = $_POST["checkin"];
            $checkout = $_POST["checkout"];
            $room = $_POST["room_id"];
            $que1 ="SELECT name FROM room WHERE room_id=$room";
            $name = dbquery($que1, $conn);
            $roomname= $name[0][0];
            if($_POST["user_id"] == 0) {
                header("location:/userlog.php?hotel=$roomname&checkind=$checkin&checkoutd=$checkout");
            } else { 
                $user = $_POST["user_id"];
                $que = "INSERT INTO bookings (check_in_date, check_out_date, user_id, room_id) VALUES ('$checkin', '$checkout', $user, $room)";
                echo $que;
                if ($conn->query($que) === FALSE) {
                    echo "Error: " . $que. "<br>" . $conn->error;
                }
                
                    }
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
        <link rel="stylesheet" href="/css/styles.css">
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
            <div class="container">    
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Congratulations</h1>
                      <p>You booked <?php echo $name[0][0]; ?> for the dates between <?php echo $checkin ?> and <?php echo $checkout ?>. You will be redirected to your profile shortly.</p>
                       <meta http-equiv="refresh" content="5;url=/profilepage.php" />
                    </div>
                </div>
            </div>
    </body>
</html>