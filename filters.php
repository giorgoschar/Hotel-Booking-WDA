<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    //Get All Data.
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
    if($_POST["maxprice"] > 0) {
        $maxprice = $_POST['maxprice'];
    } elseif ($_POST["maxprice"] == 0) {
        $maxprice = 0;
    }
    //Filter and get results
    if(!empty($city)) {
        if($roomtype == [] && $maxprice !== 0) {
            $que2 = "SELECT * FROM room WHERE city='$city' AND price < '$maxprice'";
            $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city'";
        } elseif ($roomtype == [] && $maxprice == 0) {
            $que2 = "SELECT * FROM room WHERE city='$city'";
            $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city'";
        } elseif($roomtype !== [] && $maxprice !== 0 ) {
            $roomtypestr = implode(',', $roomtype);
            //echo $roomtypestr;
            $que2 = "SELECT * FROM room WHERE city='$city' AND room_type in ({$roomtypestr}) AND price < '$maxprice'";
            $que3 = "SELECT MAX(price) AS maxPrice FROM room WHERE city='$city' AND room_type in ({$roomtypestr})";
        } elseif($roomtype !== [] && $maxprice ==0) {
            $roomtypestr = implode(',', $roomtype);
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
            foreach ($results as $res) {
                $checkDateBool = FALSE;
                $bookingque = "SELECT bookings.check_in_date, bookings.check_out_date FROM bookings WHERE room_id=".$res[0];
                $bookingsql = dbquery($bookingque, $conn);
                if($checkin !== "" && $checkout !== "" && !empty($bookingsql)) {
                    $indate = strtotime($checkin);
                    $outdate = strtotime($checkout);
                    foreach ($bookingsql as $booking) {
                        $bookedindate= strtotime($booking["check_in_date"]);
                        $bookedoutdate = strtotime($booking["check_out_date"]);
                              //echo $indate . "<br>";
                             //echo $bookedindate . "<br>";
                              //echo $outdate . "<br>";
                              //echo $bookedoutdate . "<br>";
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
                            <p class='price'>Per Night: <strong><?php echo $res["price"]?></strong>€</p>
                            <div class="dates">
                                <a class="customC" href="learnmore.php?hname=<?php echo $res["name"]?>&checkin=<?php echo $checkin?>&checkout=<?php echo $checkout;?>">Learn More</a>
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


