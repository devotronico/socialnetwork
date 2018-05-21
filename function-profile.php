<?php
function Profiles2(){
if ( $_SESSION )
{
    $mysqli = $GLOBALS['mysqli'];
    if ( array_key_exists('userid', $_GET) ) 
    {
        $id = (int)$_GET['userid']; // il profilo degli altri utenti
    }
    else    
    {
        $id = (int)$_SESSION["id"]; // il profilo dell' utente
    }

    $_SESSION['otherid'] = $id;

$sql = "SELECT Tweets.*,Users.id, Users.username, Users.image
FROM Users, Tweets
WHERE Users.id = $id 
AND Tweets.userid = $id
ORDER BY Tweets.id_post
DESC LIMIT ". MAXLOADTWEET;     
        
        
        $res = $mysqli->query($sql);   //echo '<pre>', var_dump($res) ,'</pre>';
        if ( $res && $res->num_rows )
        {   
            $arr=[];
            while( $row = $res->fetch_assoc() ) 
            {
                 $arr[] = $row;   
            }
            return $arr;
        }
        else { return "Nessun post è stato ancora pubblicato"; }
        $res->free_result();
        $mysqli->close;
    }
    else
    {
        return "Loggati o iscriviti per vedere i tuoi post personali o quelli delle persone che segui!";
    }  
}  /// PROFILO
?>