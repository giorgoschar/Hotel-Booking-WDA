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
        $token = $_POST["token"];
        if(!empty($_POST["username"]) && !empty($_POST["password"]) && $_SESSION["token"] === $token) {
            $uname = $_POST["username"];
            $pw = $_POST["password"];
            $que = "SELECT * FROM user WHERE username='$uname' AND password ='$pw'";
            $loginfo = dbquery($que,$conn);
            if(count($loginfo)>0) {
                $_SESSION["username"] =$uname;
                $_SESSION["userid"] = $loginfo[0][0];
                ?> 
                    <Script>
                        var userid = <?php echo $_SESSION["userid"]; ?>;
                    </script> 
                <?php
                printf("<li class=\"nav-item\"><a class=\"nav-link text-danger\" href=\"/profilepage.php\"><i class=\"fas fa-user\"></i>&nbsp;".$_SESSION["username"] . "</a></li><li class=\"nav-item\"> <a class=\"nav-link text-danger\" href=\"/logout.php\"/logout.php?page=index.php\"><i class=\"fas fa-sign-out-alt\"></i>&nbsp;Logout</a></li>");
            } else {
                echo "false";
            }
        }
    }
?>