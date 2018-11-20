<?php
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
        $rating = mysqli_real_escape_string($conn,$_POST['rating']);
        $textarea = mysqli_real_escape_string($conn,$_POST['textarea']);
        $roomid = mysqli_real_escape_string($conn,$_POST['roomid']);
    }
    $ok = true;

    if ( !isset($rating) || empty($rating) ) {
        $ok = false;
        echo $ok;
    }
    if ($rating < 1 || $rating > 5) {
        $ok= false;
        echo $ok;
    }
    ?>
<html>
    <?php
    if ($ok) {
        $que = "INSERT INTO reviews (rate, txt, user_id, room_id)  VALUES ($rating,'$textarea', $userid, $roomid) ";
        if ($conn->query($que) === FALSE) {
            echo "Error: " . $que. "<br>" . $conn->error;
        } else {
            
            $que1 = "SELECT reviews.*, user.username FROM reviews INNER JOIN user  on reviews.user_id = user.user_id WHERE reviews.room_id=$roomid ORDER BY reviews.rate DESC";
            $reviews = dbquery($que1,$conn);
            //var_dump($reviews);
            if(empty($reviews)){
                echo "No Reviews Found";
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
                    printf("<p class=\"reviewdesc\">$review[2]</p><br>");
                    $t= $t + 1;
                }
            }              
        }
    }

?>
</html> 