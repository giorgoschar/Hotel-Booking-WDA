<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    if(isset($_SESSION["username"])){
       echo "exit";
       exit();
    } else {
        if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["passconf"]) && !empty($_POST["email"])) {
            $uname = mysqli_real_escape_string($conn,$_POST["username"]);
            $pw = mysqli_real_escape_string($conn,$_POST["password"]);
            $pwcf = mysqli_real_escape_string($conn,$_POST["passconf"]);
            $email =mysqli_real_escape_string($conn,$_POST["email"]);
            $isValidEmail=TRUE;
            $que2 = "SELECT user.username FROM user WHERE username='$uname'";
            $res = dbquery($que2,$conn);
            $foundDuplicate=false;
            if (count($res)>0) {
                echo "foundDuplicate";
                $foundDuplicate=true;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $isValidEmail=false;
                echo "false";
            }
            if($pw===$pwcf && $isValidEmail==TRUE && $foundDuplicate==FALSE ) {
                $que = "INSERT INTO user (user.username,user.email,user.password) VALUES ('$uname','$email','$pw')";
                if ($conn->query($que) === FALSE) {
                    echo "error";
                } else {
                    echo "done";
                }             
            }
        }
    }
?>