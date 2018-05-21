<?php
session_start();

    $db_server = "shareddb1d.hosting.stackcp.net";
    $db_username = "socialnetwork-323158d9"; 
    $db_password = "9KTaefhNpi5t";
    $db_database = "socialnetwork-323158d9";
    
    $link = mysqli_connect($db_server, $db_username, $db_password, $db_database);
    
    
    if (mysqli_connect_errno())
    {
        print_r(mysqli_connect_errno);
        exit();
    }
?>