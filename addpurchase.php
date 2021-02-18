<?php

    require 'db_connection.php';
    include("auth_session.php");

$addpurchase = mysqli_query($conn,"INSERT INTO `Purchases`(
    `Comment`,
    `game_id`,
    `Collection`,
    `Owned`,
    `Delivered`,
    `Cost`,
    `Delivery Date`
)
VALUES(
    'test',
    $game_id,
    'Blank',
    'Y',
    'Y',
    '0.00',
    '2021-01-01'
)"); // delete query


if($addpurchase)
{
    mysqli_close($conn); // Close connection
    header("location:addgame.php"); // redirects to all records page
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}
?>