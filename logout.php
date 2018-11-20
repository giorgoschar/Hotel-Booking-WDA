 <?php
 session_start();  
 session_destroy();
 //Sending the user back to the page he was using GET
 if (isset($_GET["page"])) {
 $page = $_GET["page"];
 header("location:" . $page);  
 } else { 
     header("location:index.php");
 }
 ?>  