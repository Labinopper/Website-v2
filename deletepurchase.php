<?php

    require '../db_connection.php';
    include("auth_session.php");

$id = $_GET['id']; // get id through query string

$del = mysqli_query($conn,"delete from Purchases where id = '$id'"); // delete query

if($del)
{
    mysqli_close($conn); // Close connection
    header("location:purchases.php"); // redirects to all records page
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}
?>