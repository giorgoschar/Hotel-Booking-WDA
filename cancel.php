<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    if(!isset($_SESSION["username"])) {
        header("location:index.php?page=profile");
    }
    if(isset($_POST["bookingid"]) && !empty($_POST["bookingid"])) {
        $bookingid = mysqli_real_escape_string($conn,$_POST["bookingid"]);
        $sql = "DELETE FROM bookings WHERE booking_id=$bookingid";
        if ($conn->query($sql) === TRUE) {
            ?>
        <?php
        } else {
            echo false;
            //echo "Error deleting record: " . $conn->error;
        }
    
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
    } else { 
        header("Location:index.php?page=profile");
    }
?>