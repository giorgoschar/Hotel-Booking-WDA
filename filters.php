<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";

    if(isset($_POST["radiocity"]) && !empty($_POST["radiocity"])) {      
        $city= $_POST['radiocity'];
    }  else { 
        $city = "";
    }
    if(isset($_POST["checkedboxes"])&&(!empty($_POST["checkedboxes"])))  {  
        $roomtype =$_POST["checkedboxes"];
    }else { 
        $roomtype = [];
    }
    if(!empty($_POST["checkin"])){
        $checkin = $_POST['checkin'];
    } else { 
        $checkin = "";
    }
    if(!empty($_POST["checkout"])){
        $checkout = $_POST['checkout'];
    } else { 
        $checkout = "";
    }
    // $range = count($checkedboxes);
    //  for($i=0;$i<$range;++$i) {
    //      echo $checkedboxes[$i];
    //  }
    if(!empty($city)) {
        if($roomtype == []) {
            $que2 = "SELECT * FROM room WHERE city='$city'";
            $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city'";
        } else {
            $roomtypestr = implode(',', $roomtype);
            //echo $roomtypestr;
            $que2 = "SELECT * FROM room WHERE city='$city' AND room_type in ({$roomtypestr})";
            $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city' AND room_type in ({$roomtypestr})";
        }      
    } else {
             $que3 = "SELECT MAX(price) AS maxPrice FROM room";
             $que2 = "SELECT * FROM room";
            }
            $results = dbquery($que2,$conn);
            $maxPrice = dbquery($que3, $conn);
            if(!empty($results)) {
                $checkDateBool = FALSE;
                foreach ($results as $res) {
                    $checkDateBool = FALSE;
                    $bookingque = "SELECT bookings.check_in_date, bookings.check_out_date FROM bookings WHERE room_id=".$res[0];
                    $bookingsql = dbquery($bookingque, $conn);
                    $indate = strtotime($checkin);
                    $outdate = strtotime($checkout);
                    foreach ($bookingsql as $booking) {
                        $bookedindate= strtotime($booking[0]);
                        $bookedoutdate = strtotime($booking[1]);
                        if($indate >= $bookedindate || $outdate <= $bookedoutdate) {
                            $checkDateBool =TRUE;
                        }
                    }
                if($checkDateBool == FALSE) {
                    $availability = "<span class=\"alert alert-success availability\">Available</span>";
                } else {
                    $availability = "<span class=\"alert alert-danger availability\">Not Available</span>";

                }
                printf("                    
                    <div class='card flex-row flex-wrap'>
                        <div class='cheader'>
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
                        <div class='cbody'>
                        <h5 class='card-title h text-uppercase'>$res[1]</h5>
                        <hr>
                        <div class='p3'>
                        <div class='p6'>$hasWifi &nbsp; $hasParking &nbsp; $receivesPets</div><br>
                        <div class='p4'>Per Night: $res[7]€</div><br>
                        <div class='p4'><i class=\"fas fa-thumbtack\"></i>$res[8], $res[3]</div>
                        </div>
                       
                    </div>
                    <div class=\"card-footer w-100\">
                        $availability
                        <a class=\"customC\" href=\"learnmore.php?hname=$res[1]&checkin=$checkin&checkout=$checkout\">Learn More</a>
                    </div>
                </div>
                <br><br>"
                );

            }
        
        }else {
                ?> <p>Results not found</p>
                <?php
            }
         ?>


