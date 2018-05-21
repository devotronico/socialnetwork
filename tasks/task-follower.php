<?php
include_once("../connection.php"); 

if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    
    $follower = (int)$_SESSION['id']; // io
    $isFollowing = (int)$_POST["userid"]; // chi ha pubblicato il tweet
    
    if ( $follower === $isFollowing )
    {
        echo "mio post";
    }
    else
    {
        $res = $mysqli->query("SELECT * FROM Follow WHERE follower = $follower AND isFollowing = $isFollowing LIMIT 1");

        if ( $res->num_rows > 0 )
        {
            $row = $res->fetch_assoc();
            $id = (int)$row['idF'];
            $mysqli->query("DELETE FROM Follow WHERE idF = ". $id ." LIMIT 1"); 
            echo "segui";
        }
        else
        {
            $mysqli->query("INSERT INTO Follow (follower, isFollowing) VALUES (". $follower .",". $isFollowing .")");
            echo "non seguire";
        }
    }
}
?>