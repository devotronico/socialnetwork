   <?php
include_once("../connection.php"); 

if($_SERVER["REQUEST_METHOD"] == "POST"){   
    
    if ( $_POST["contentTweet"] != "" )
    {
        if ( strlen($_POST["contentTweet"]) < 51 )
        {
            $id = (int)$_SESSION["id"];

    $mysqli->query("UPDATE Users SET tweetnumber = tweetnumber + 1 WHERE id = $id") or die($mysqli->error);//Incrementa il contatore dei post
    $res = $mysqli->query("SELECT tweetnumber FROM Users WHERE id = $id") or die($mysqli->error); // Seleziona colonna del numero tweet
            $user = $res->fetch_assoc();
            $usernumtweet = $user['tweetnumber']; // numero tweet

            //INSERISCI UN NUOVO POST NELLA TABELLA TWEETS 
            $tweet = $mysqli->escape_string($_POST["contentTweet"]);
            $res = $mysqli->query("INSERT INTO Tweets ( tweet, userid, usernumtweet, datetime ) VALUES ( '$tweet', '$id', '$usernumtweet', now() )");
  
            if ( $res )
            {   
$sql = "SELECT Tweets.*,Users.id, Users.username, Users.image
 FROM Users, Tweets
 WHERE Users.id = $id 
 AND Tweets.usernumtweet = $usernumtweet
 LIMIT 1";                   
                
      $res = $mysqli->query($sql);   //echo '<pre>', var_dump($res) ,'</pre>';
    if ( $res && $res->num_rows )
    {   
        $arr=[];
        while( $row = $res->fetch_assoc() ) 
        {
             $arr[] = $row;   
        }
        echo json_encode($arr);
    }
    else {  echo "Si è verificato un errore, riprova più tardi"; }
    $res->free_result();
    $mysqli->close;              
            }
            else
            {
                echo "Si è verificato un errore, riprova più tardi";
            }
        }
        else
        {
            echo "Non puoi scivere messaggi più lunghi di 50 caratteri";
        }
    }
    else
    {
        echo "Il messaggio è vuoto";
    }
}

/****
include_once("../connection.php"); 

if($_SERVER["REQUEST_METHOD"] == "POST"){   
    
    if ( $_POST["contentTweet"] != "" )
    {
        if ( strlen($_POST["contentTweet"]) < 51 )
        {
            $userid  =   $mysqli->escape_string($_SESSION["id"]);

    $mysqli->query("UPDATE Users SET tweetnumber = tweetnumber + 1 WHERE id = '$userid'") or die($mysqli->error);//Incrementa il contatore tweet
    $sql = $mysqli->query("SELECT tweetnumber FROM Users WHERE id = '$userid'") or die($mysqli->error);//Seleziona colonna del numero tweet
            $user = $sql->fetch_assoc();
            $usernumtweet = $user['tweetnumber']; // numero tweet


            $tweet = $mysqli->escape_string($_POST["contentTweet"]);
            $query = "INSERT INTO Tweets ( tweet, userid, usernumtweet, datetime ) VALUES ( '$tweet', '$userid', '$usernumtweet', now() )";
  

            if ( $mysqli->query($query) )
            {
                $res = $mysqli->query("SELECT * FROM Tweets WHERE userid = ". $userid ." ORDER BY id DESC LIMIT 1");
                $row = $res->fetch_assoc();

                $mes = "<div class='tweet' lastId='". $row['id'] ."'>";
                $mes .= "<span class='timeago'>[".$row['id']."] ho postato il mio tweet numero ".$row['usernumtweet']." - adesso</span>";
                $mes .= "<p>". $row["tweet"] ."</p>";
                $mes .= "</div>";   
                echo $mes;
            }
            else
            {
                echo "Si è verificato un errore, riprova più tardi";
            }
        }
        else
        {
            echo "Non puoi scivere messaggi più lunghi di 50 caratteri";
        }
    }
    else
    {
        echo "Il messaggio è vuoto";
    }
    }
*////


?>