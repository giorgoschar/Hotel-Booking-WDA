<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    if(!isset($_POST["userid"])){
        header("Location:index.php");
    }
    elseif($_POST['userid']==0 || empty($_POST['userid'])) {
        echo "exit";
        exit();
    } else {
        $userid = mysqli_real_escape_string($conn,$_POST['userid']);
        $checkin = mysqli_real_escape_string($conn,$_POST["checkin"]);
        $checkout = mysqli_real_escape_string($conn,$_POST["checkout"]);
        $room = mysqli_real_escape_string($conn,$_POST["roomid"]);
    }
    $bookingque = "SELECT bookings.* FROM bookings INNER JOIN user on bookings.user_id=user.user_id WHERE room_id=". $room;
    $bookingsql = dbquery($bookingque, $conn);
    $checkinDateArr = explode('-',$checkin);
    $checkoutDateArr = explode('-',$checkout);
    $checkDateBool = FALSE;
    if(count($checkinDateArr) == 3 && count($checkoutDateArr) == 3) {
        if(checkdate($checkinDateArr[1],$checkinDateArr[2], $checkinDateArr[0]) && checkdate($checkoutDateArr[1],$checkoutDateArr[2],$checkoutDateArr[0])) {
            $indate = strtotime($checkin);
            $outdate = strtotime($checkout);
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
        }
    }
        if($checkDateBool == FALSE) {
                $que = "INSERT INTO bookings (check_in_date, check_out_date, user_id, room_id) VALUES ('$checkin', '$checkout', $userid, $room)";
                if ($conn->query($que) === FALSE) {
                    echo "error";
                }             
            }
         else {
            echo "error2";
        }
    
    
?>