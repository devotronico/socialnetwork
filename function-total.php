<?php
function Total2(){ 
 
    $mysqli = $GLOBALS['mysqli'];
    if ( !array_key_exists('userid', $_GET) ) 
    {
        $id = (int)$_SESSION["id"]; // il profilo dell' utente
    }
    else    
    {
        $id = (int)$_GET['userid']; // il profilo degli altri utenti
    }

$sql = "SELECT Tweets.*, Users.username, Users.image 
FROM Tweets
INNER JOIN Users
ON Users.id = Tweets.userid
ORDER BY Tweets.id_post
DESC LIMIT ". MAXLOADTWEET;

$res = $mysqli->query($sql);
if ( $res && $res->num_rows )
{   
    $arr=[];
    while( $row = $res->fetch_assoc() ) 
    {
         $arr[] = $row;   
    }
    return $arr;
}
else { return "Non sono stati ancora pubblicati dei post"; }
$res->free_result();
$mysqli->close;
}  /// TOTAL





/*

function Total3(){
    $mysqli = $GLOBALS['mysqli'];
    $result = $mysqli->query("SELECT * FROM Tweets ORDER BY id DESC LIMIT ".MAXLOADTWEET); 
    if ($result->num_rows === 0) // da controllare cosa restituisce
    {
        echo "Non ci sono tweets da mostrare";
    }
    else
    {
        while ( $tweet = $result->fetch_assoc() )
        {
            $userid = (int)$tweet["userid"]; 
            $user_result = $mysqli->query("SELECT * FROM Users WHERE id = '$userid'");
            $user = $user_result->fetch_assoc();
            echo "<div class='tweet' lastId='". $tweet['id'] ."'>";
            echo "<div class='tweet-left'><img src='img/0.jpg' width='50px'></div>";
            echo "<div class='tweet-right'>";
                       
echo "<span class='timeago'>[".$tweet['id']."] <a href='?page=profiles&userid=".$user["id"]."'>". $user['username'] ."</a>
ha postato il suo tweet numero ".$tweet['usernumtweet']." - ".time_since(time() - strtotime($tweet["datetime"]))." ago</span>";             
echo "<p>". $tweet["tweet"] ."</p>";            
    
             // SEGUI / NON SEGUIRE / MIO POST 
           if ( $_SESSION ) {  //FollowLink($link); // FUNZIONE DA SVILUPPARE
                $follower = (int)$_SESSION['id']; // io
                $isFollowing = (int)$tweet["userid"]; // chi ha pubblicato il tweet
                if ( $follower === $isFollowing ) // se io sono lo stesso che ha pubblicato questo tweet
                {
                    echo "<p class='toggleFollow' data-userId='".$tweet['userid']."'><a href='#' class='follow-link'>mio post</a></p>";
                }
                else
                {
                    $foll_res = $mysqli->query("SELECT * FROM Follow WHERE follower = $follower AND isFollowing = $isFollowing LIMIT 1"); 
                    if ( $foll_res->num_rows > 0 )
                    {
                        echo "<p class='toggleFollow' data-userId=".$isFollowing."><a href='#' class='follow-link'>non seguire</a></p>"; 
                    }
                    else
                    {
                        echo "<p class='toggleFollow' data-userId=".$isFollowing."><a href='#' class='follow-link'>segui</a></p>";
                    }
                }  
            } ///  FOLLOW LINK SE SIAMO LOGGATI
           
            echo "</div>";
             echo "<div class='tweet-clear'></div>";
           echo "</div>";  
        }
        echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>';
    }
}  // GLOBAL TWEET
*/

?>