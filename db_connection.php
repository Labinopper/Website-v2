<?php

     $dbhost = "localhost";
     $dbuser = "u453667767_labinopper";
     $dbpass = "Laboohibgwtmc1";
     $db = "u453667767_main";
     $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
     
//     function OpenCon()
//     {
//     return $conn;
//     }
     
//     function CloseCon($conn)
//     {
//     $conn -> close();
//     }
       
?>