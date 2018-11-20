<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    $userid = $_POST['userid'];
    $hotel = $_POST['hotel'];
    if($userid == 0) {
        echo "exit";
        exit();
    }
    $que = "SELECT favorites.status FROM favorites WHERE room_id=$hotel AND user_id=$userid";
    $favorites = dbquery($que,$conn);
    if (empty($favorites)){ 
        $status = 1;
        $que2 = "INSERT INTO favorites (status, user_id, room_id) VALUES ($status,$userid, $hotel)";
        if ($conn->query($que2) === FALSE) {
            echo "Error: " . $que. "<br>" . $conn->error;
        } else {
            printf("| <p class='p1' id='heartSelect'>&nbsp;<i class='fas fa-heart' onclick='addToFavorites(this.id)' style='color:orange'></i></p>");  
        }
    } else if ($favorites[0][0] == 0) { 
        $status=1;
        $que2 = "UPDATE favorites SET favorites.status = $status WHERE room_id=$hotel AND user_id=$userid";
        if ($conn->query($que2) === FALSE) {
            echo "Error: " . $que. "<br>" . $conn->error;
        } else {
            printf("| <p class='p1' id='heartSelect'>&nbsp;<i class='fas fa-heart' onclick='addToFavorites(this.id)' style='color:orange'></i></p>");  
        } 
    } else { 
        $status=0;
        $que2 = "UPDATE favorites SET favorites.status = $status WHERE room_id=$hotel AND user_id=$userid";
        if ($conn->query($que2) === FALSE) {
            echo "Error: " . $que. "<br>" . $conn->error;
        } else {
            printf("| <p class='p1' id='heartSelect'>&nbsp;<i class='far fa-heart' onclick='addToFavorites()' style='color:orange'></i></p>");  
        } 
    }
?>