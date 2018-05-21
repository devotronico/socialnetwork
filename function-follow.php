<?php
function Follow2(){ 
if ( $_SESSION )
{
    $mysqli = $GLOBALS['mysqli'];
    if ( !array_key_exists('userid', $_GET) ) 
    {
        $id = (int)$_SESSION["id"]; // il profilo dell' utente
    }
//    else    
//    {
//        $id = (int)$_GET['userid']; // il profilo degli altri utenti
//    }

 //echo '<pre>', var_dump($id, true) ,'</pre>';
 $sql = "SELECT * FROM Follow
 INNER JOIN Tweets 
 ON Tweets.userid = Follow.following
 INNER JOIN Users 
 ON Users.id = Follow.following
 WHERE Follow.follower = $id
 ORDER BY Tweets.id_post
 DESC LIMIT ". MAXLOADTWEET;    
    

$res = $mysqli->query($sql); 
if ( $res && $res->num_rows )
{   
    $array=[];
    while( $row = $res->fetch_assoc() ) 
    {
         $array[] = $row;   
    }
    return $array;
}
else { return "Le persone che segui non hanno ancora pubblicato dei post"; }
$res->free_result();
$mysqli->close;
}
else { return "Loggati per vedere cosa postano le persone che segui"; }
}  /// FOLLOW






/*
function Follow2(){ 
 
        $mysqli = $GLOBALS['mysqli'];
        if ( !array_key_exists('userid', $_GET) ) 
        {
            $id = (int)$_SESSION["id"]; // il profilo dell' utente
        }
        else    
        {
            $id = (int)$_GET['userid']; // il profilo degli altri utenti
        }
    
$sql = "SELECT Tweets.*,Users.username FROM Tweets INNER JOIN Users ON Tweets.userid = Users.id ORDER BY Tweets.datetime DESC LIMIT ". MAXLOADTWEET;

        $res = $mysqli->query($sql);
        if ( $res && $res->num_rows )
        {   
            $array=[];
            while( $row = $res->fetch_assoc() ) 
            {
                 $array[] = $row;   
            }
            return $array;
        }
        else { return "Non sono stati ancora pubblicati dei post"; }
        $res->free_result();
        $mysqli->close;
}  /// TOTAL


function Follow(){
if ( $_SESSION )
{
    $mysqli = $GLOBALS['mysqli'];
    $follower = (int)$_SESSION['id']; 
    $res = $mysqli->query("SELECT * FROM Tweets 
    JOIN Follow ON Tweets.userid = Follow.isFollowing
    WHERE Follow.follower = ".$follower."
    ORDER BY Tweets.id DESC LIMIT ".MAXLOADTWEET);
    //ORDER BY Tweets.datetime DESC LIMIT 10";
    if ( $res->num_rows > 0 )
    {
        while ( $row = $res->fetch_assoc() )
        {
            $friend = (int)$row['userid']; 
            $user_res = $mysqli->query("SELECT username FROM Users WHERE id = $friend");
            $user = $user_res->fetch_assoc();
            echo "<div class='tweet' lastId='". $row['id'] ."'>";
echo "<p><a href='?page=profiles&userid=".$row["userid"]."'>". $user['username'] ."</a><span class='timeago'> ha postato ". time_since(time() - strtotime($row["datetime"])) ." fa</span></p>";
            echo "<p>". $row["tweet"] ."</p>";

            $isFollowing = (int)$row["userid"];
            if ( $follower === $isFollowing )
            {
                echo "<p class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</p>";
                 //echo "<p><a href='#' class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</a></p>";
            }
            else
            {
                $follow_res = $mysqli->query("SELECT * FROM Follow WHERE follower = $follower AND isFollowing = $isFollowing LIMIT 1"); 
                if ( $follow_res->num_rows > 0 )
                {
                    echo "<p class='toggleFollow' data-userId='".$isFollowing."'>Non Seguire!</p>";
                     //echo "<p><a href='#' class='toggleFollow' data-userId='".$isFollowing."'>Non Seguire!</a></p>";
                }
                else
                {
                    echo "<p class='toggleFollow' data-userId='".$isFollowing."'>Segui!</p>";
                     //echo "<p><a href='#' class='toggleFollow' data-userId='".$isFollowing."'>Segui!</a></p>";
                }
            }  //  FOLLOWLINK end

            echo "</div>";   
        }
        echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>';
    }
    else
    {
         echo "<p>Non stai seguendo Nessuno!</p>";
    }    
}
else
{
    echo "<p>Loggati o iscriviti per seguire altre persone!</p>";
}  
}  // FOLLOWING

*/





