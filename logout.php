 <?php
 session_start();  
 session_destroy();
 if (isset($_GET["page"])) {
 $page = $_GET["page"];
 header("location:" . $page);  
 } else { 
     header("location:index.php");
 }
 ?>  