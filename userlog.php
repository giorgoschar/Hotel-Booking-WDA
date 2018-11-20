<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "dbconn.php";
    if(isset($_SESSION["username"])){
        header("location:index.php");
    } else {
        if(isset($_POST["submit2"])){ 
            $uname = $_POST["username"];
            $pw = $_POST["password"];
            $que = "SELECT * FROM user WHERE username='$uname' AND password ='$pw'";
            //echo $que;
            $loginfo = dbquery($que,$conn);
            //echo $loginfo[0][0];
            //var_dump($loginfo);
            if(count($loginfo)>0) {
                $_SESSION["username"] =$uname;
                $_SESSION["userid"] = $loginfo[0][0];
                if(!empty($_POST["hotel"])){
                    $checkind =$_POST["checkind"];
                    $hotel = $_POST["hotel"];
                    $checkoutd = $_POST["checkoutd"];    
                    $que1 = "SELECT name FROM room WHERE room_id = $hotel";
                    $res = dbquery($que1,$conn);
                    $loc1="learnmore.php?hname=".$res[0][0]."&checkin=".$checkind."&checkout=".$checkoutd;           
                    
                }elseif(!empty($_POST["profilepage"])) {
                    $loc1 = "profilepage.php";
                }
                 else {
                    $loc1="index.php";
                    
                }
                echo $loc1;
                header("location:" . $loc1);
            } else {
                $message ="Username or Password is not Correct";
            } 
            
    
        }
    }
    

?>


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
        <link rel="stylesheet" href="/css/logstyles.css">
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
            </div>  
        </nav>
        <div class="container">    
            <div class="row">
                <div class="col-sm-4 loginform">
                    <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" method="post" class="login">
                        <?php 
                            if(!empty($message)){ 
                        ?>
                                <p class="alert alert-danger"><?php echo $message ?></p>
                       <?php
                            } 
                        ?>
                       <label for="username" class="labels">Username:</label><br> 
                       <input type="text" class="form-control"   name="username">
                       <label for="password" class="labels">Password:</label><Br>
                       <input type="password" class="form-control"  name="password">
                       <?php if(!empty($_GET["hotel"])){ ?>
                        <input type="hidden" name="hotel" value="<?php if($_GET["hotel"]) { echo $_GET["hotel"]; } else { echo ""; }?>">
                        <input type="hidden" name="checkind" value="<?php echo $_GET["checkin"]; ?>">
                        <input type="hidden" name="checkoutd" value="<?php echo $_GET["checkout"]; ?>">
                        <?php 
                        } elseif(!empty($_GET["page"])) {
                            ?>
                                <input type="hidden" name="profilepage" value="<?php echo $_GET["page"];?>">
                            <?php 
                        }
                        ?>
                            <input type="submit" class="btn" name="submit2" Value="Login">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>