<?php
    include("../connection.php"); 
 
if($_SERVER["REQUEST_METHOD"] === "POST"){  
    
function time_ago($since){
    $chunks = array(
    array(60 * 60 * 24 * 365 , 'year'),
    array(60 * 60 * 24 * 30 , 'month'),
    array(60 * 60 * 24 * 7, 'week'),
    array(60 * 60 * 24 , 'day'),
    array(60 * 60 , 'hour'),
    array(60 , 'minute'),
    array(1 , 'second')
    );
    for ($i = 0, $j = count($chunks); $i < $j; $i++)
    {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) { break; }
    }
    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
} /// TIME AGO

$lastIdPost = (int)$_POST['lastId'];
$postNum = (int)$_POST['pageNum'];  
    
if ( $_POST['page'] === 'total' ) { //

 $sql = "SELECT Tweets.*, Users.username, Users.image 
 FROM Tweets
 INNER JOIN Users
 ON Users.id = Tweets.userid
 WHERE Tweets.id_post < $lastIdPost
 ORDER BY Tweets.id_post
 DESC LIMIT ". MAXLOADTWEET;

    $res = $mysqli->query($sql); //*if ( $res ) { echo 'ciao'; }
   
    if ( $res && $res->num_rows )
    {   
        $arr=[];
        while( $row = $res->fetch_assoc() ) 
        {
             $arr[] = $row;   
        }
        echo json_encode($arr); 
    }
    else {  echo ''; }
    $res->free_result();
    $mysqli->close;                           
}  // TOTAL
else if ( $_POST['page'] == 'following' ) {// FOLLOWING
if ( $_SESSION ) { 

    $id = (int)$_SESSION["id"];

    $sql = "SELECT * FROM Follow
     INNER JOIN Tweets 
     ON Tweets.userid = Follow.following
     INNER JOIN Users 
     ON Users.id = Follow.following
     WHERE Follow.follower = $id 
     AND Tweets.id_post < $lastIdPost
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
        echo json_encode($arr); 
    }
    else {  echo ''; }
    $res->free_result();
    $mysqli->close;     
    } 
} // FOLLOWING
else if ( $_POST['page'] === 'profiles' ) { 
   // $test = ''; 
 //   if ( isset( $_SESSION['id'] ) ) { $test .= 'S_id ='.$_SESSION['id']; } // ok
 //   if ( isset( $_SESSION['otherid'] ) ) { $test .= ' - S_otherid = '.$_SESSION['otherid']; } 
    if ( $_SESSION )
    {/*
        if ( array_key_exists('userid', $_GET) ) {   
            $id = (int)$_GET['userid']; // il profilo degli altri utenti
        }else { 
            $id = (int)$_SESSION["id"]; // il profilo dell' utente
        }*/
        $id = (int)$_SESSION["otherid"];
      //  $test .= ' - id = '.$_SESSION['otherid']; echo $test;
  
$sql = "SELECT Tweets.*,Users.id, Users.username, Users.image
 FROM Users, Tweets
 WHERE Users.id = $id 
 AND Tweets.userid = $id
 AND Tweets.id_post < $lastIdPost
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
        echo json_encode($arr);
    }
    else {  echo ''; }
    $res->free_result();
    $mysqli->close;
    }
} // PROFILO
}

 
/*

  /*      
    $a = [
        [
        'nome' => 'Daniele',
        'cognome' => 'Manzi'
        ],
        [
        'nome' => 'Maria',
        'cognome' => 'Giugliano'
        ]
    ];
       echo json_encode($a);   
       */     

/*
    if ( $_POST["action"] == "toggleFollow" ) {
        $follower = mysqli_real_escape_string($link, $_SESSION['id']);
        $isFollowing = mysqli_real_escape_string($link, $_POST['userId']);
        if ( $follower == $isFollowing )
        {
            echo "Mio Post";
        }
        else
        {
            $query = "SELECT * FROM Follow WHERE follower = ". $follower ." AND isFollowing = ". $isFollowing ." LIMIT 1"; 
            $result = mysqli_query($link, $query);
            if ( mysqli_num_rows($result) > 0 )
            {
                $row = mysqli_fetch_assoc($result);
                $id = mysqli_real_escape_string($link, $row['idF']);
                mysqli_query($link, "DELETE FROM Follow WHERE idF = ". $id ." LIMIT 1"); 
                echo "Segui";
            }
            else
            {
                mysqli_query($link, "INSERT INTO Follow (follower, isFollowing) VALUES (". $follower .",". $isFollowing .")");
                echo "Non Seguire";
            }
        }
    }

 */// DA CONTROLLARE
/*
else if ( $_POST['page'] == 'following' ) {// FOLLOWING
    if ( $_SESSION ) { //  echo 'test';
        $loadMess = '';
        $follower = mysqli_real_escape_string($link, $_SESSION['id']); 
        
        $query = "SELECT * FROM Tweets 
        JOIN Follow ON Tweets.userid = Follow.isFollowing
        WHERE Follow.follower = " .$follower. "
        AND Tweets.id < ". $_POST['lastId'] ."
        ORDER BY Tweets.id DESC LIMIT 8";
        //ORDER BY Tweets.datetime DESC LIMIT 10";
        
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) == 0) { echo false; }  else { 
            $loadMess .= "<span class='badge badge-light'>Pagina ". $_POST['pageNum'] ."</span>"; // RITORNA IL NUMERO DI PAGINE VISUALIZZATE
            while ( $row = mysqli_fetch_assoc($result) )
            { // $loadMess .= $row['id'] ." -";
                $friend = mysqli_real_escape_string($link, $row['userid']); 
                $user_query = "SELECT email FROM Users WHERE id = ".$friend."";
                $user_result = mysqli_query($link, $user_query); 
                $user = mysqli_fetch_assoc($user_result);
                $loadMess .= "<div class='tweet' lastId='". $row['id'] ."'>";
$loadMess .= "<p><a href='?page=profiles&userid=".$row["userid"]."'>". $user['email'] ."</a><span class='timeago'> ha postato ". time_since2(time() - strtotime($row["datetime"])) ." fa</span></p>";
                $loadMess .= "<p>". $row["tweet"] ."</p>";
                $loadMess .= "</div>";  
            }
              echo $loadMess;
        } 
    } 
} // FOLLOWING
*/// FOLLOWING
?>