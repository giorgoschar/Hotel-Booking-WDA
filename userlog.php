<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    //if user is logged in, terminate the script
    if(isset($_SESSION["username"])){
       echo "exit";
       exit();
    } else {
        //get the token from the form
        $token = $_POST["token"];
        //check if username and password are not empty and that the session token is the same as the forms token
        if(!empty($_POST["username"]) && !empty($_POST["password"]) && $_SESSION["token"] === $token) {
            $uname = $_POST["username"];
            $pw = $_POST["password"];
            //look inside the table user for the username and password
            $que = "SELECT * FROM user WHERE username='$uname' AND password ='$pw'";
            $loginfo = dbquery($que,$conn);
            //if they exist then login the user
            if(count($loginfo)>0) {
                $_SESSION["username"] =$uname;
                $_SESSION["userid"] = $loginfo[0][0];
                ?> 
                    <Script>
                        //add userid to javascript so it can immediately process AJAX requests.
                        var userid = <?php echo $_SESSION["userid"]; ?>;
                    </script> 
                <?php
                //print the right navbar item.
                printf("<li class=\"nav-item\"><a class=\"nav-link text-danger\" href=\"/profilepage.php\"><i class=\"fas fa-user\"></i>&nbsp;".$_SESSION["username"] . "</a></li><li class=\"nav-item\"> <a class=\"nav-link text-danger\" href=\"/logout.php\"/logout.php?page=index.php\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Logout</a></li>");
            } else {
                echo "false";
            }
        }
    }
?>