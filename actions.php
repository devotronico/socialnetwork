<?php
    include("connection.php"); 
//var_dump($_GET);
    $message = "";
    if ( $_GET["action"] == "loginSignup" ) { // user
        if ( !$_POST["email"] )
        {
             $message = "il campo email è vuoto<br>";
        }
        else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
        {
             $message = "il campo email non è valido<br>";
        } 

        if ( !$_POST["password"] )
        {
             $message .= "il campo password è vuoto";
        }

        if ( $message != "" )
        {
            $message = "ci sono i seguenti errori:<br>". $message; 
            echo $message;
        }
        else
        {
            if ( $_POST["loginActive"] == "registrati" ) { //  0 REGISTRAZIONE --------------------------------------------------------------------------------- REGISTRAZIONE
                $email = mysqli_real_escape_string($link, $_POST["email"]);
                $query = "SELECT * FROM Users WHERE email= '". $email ."' LIMIT 1";
                $result = mysqli_query($link, $query);
                if ( mysqli_num_rows($result) == 0 )
                {
                    $password = mysqli_real_escape_string($link, $_POST["password"]);
                    $password = md5(md5(mysqli_insert_id($link)).$password);      
                    $query = "INSERT INTO Users (email, password) VALUES ('".$email."', '".$password."')";
                    if ( mysqli_query($link, $query) )
                    {
                        $_SESSION["id"] = mysqli_insert_id($link); 
                        $message = "Registrato";
                        echo $message;
                    }
                }
                else
                {
                    $message = "email già registrata";
                    echo $message;
                }
            }
            else if ( $_POST["loginActive"] == "accedi" )  { // 1 LOGIN ------------------------------------------------------------------------------------- LOGIN
     
                $email = mysqli_real_escape_string($link, $_POST["email"]);
                $query = "SELECT * FROM Users WHERE email = '". $email ."' LIMIT 1";
                $result = mysqli_query($link, $query);
                if ( mysqli_num_rows($result) == 1 )
                { 
                    $password = mysqli_real_escape_string($link, $_POST["password"]);
                    $password = md5(md5(mysqli_insert_id($link)).$password);      
                    $row = mysqli_fetch_assoc($result);
                    if ( $row["password"] == $password )
                    {
                        $_SESSION["id"] = $row["id"]; 
                       echo 'Loggato'; 
                    }
                    else
                    {
                        $message = "password errata";
                        echo $message;
                    }
                }
                else
                {
                    $message = "email errata";
                    echo $message;
                }
            }
        }
    }

    if ( $_GET["action"] == "toggleFollow" ) {
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

    if ( $_GET["action"] == "postTweet" ) {
        if ( $_POST["contentTweet"] != "" )
        {
            if ( strlen($_POST["contentTweet"]) < 51 )
            {
                $id  =   mysqli_real_escape_string($link, $_SESSION["id"]);
                $tweet = mysqli_real_escape_string($link, $_POST["contentTweet"]);
                $query = "INSERT INTO Tweets ( tweet, userid, datetime ) VALUES ( '". $tweet ."',". $id .", now() )";

                if (mysqli_query($link, $query))
                {
                    echo "1";
                }
                else
                {
                    echo "FAIL";
                }
            }
            else
            {
                echo "il messaggio è più lungo di 50 caratteri";
            }
        }
        else
        {
            echo "il messaggio è vuoto";
        }
    }

    if ( $_GET['action'] == 'carica' ) { 
        function time_since2($since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hour'),
        array(60 , 'minute'),
        array(1 , 'second')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
} 
        if ( $_GET['page'] == 'timeline' ) {
           
            $loadMess = '';
            $query = "SELECT * FROM Tweets WHERE id < ". $_GET['lastId'] ." ORDER BY id DESC LIMIT 8";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) == 0) { echo false; }  else {  
               // $loadMess .= "<div class='pageNumClass'>". $_GET['pageNum'] ."</div>"; // RITORNA IL NUMERO DI PAGINE VISUALIZZATE
                  $loadMess .= "<span class='badge badge-light'>Pagina ". $_GET['pageNum'] ."</span>"; // RITORNA IL NUMERO DI PAGINE VISUALIZZATE
                while ( $row = mysqli_fetch_assoc($result) )
                {
                    $user_query = "SELECT email FROM Users WHERE id = ".mysqli_real_escape_string($link, $row["userid"])."";
                    $user_result = mysqli_query($link, $user_query); 
                    $user = mysqli_fetch_assoc($user_result);
                    $loadMess .= "<div class='tweet' lastId='". $row['id'] ."'>";
     $loadMess .= "<p><a href='?page=profiles&userid=".$row["userid"]."'>". $user['email'] ."</a><span class='timeago'> ha postato ". time_since2(time() - strtotime($row["datetime"])) ." fa</span></p>"; 
                    $loadMess .= "<p>". $row["tweet"] ."</p>";

                     // SEGUI / NON SEGUIRE / MIO POST 
                    if ( $_SESSION ) // ( isset($_SESSION) )
                    {
                        $follower = mysqli_real_escape_string($link, $_SESSION['id']);
                        $isFollowing = mysqli_real_escape_string($link, $row["userid"]);
                        if ( $follower == $isFollowing )
                        {
                             $loadMess .= "<p class='toggleFollow' data-userId='". $row['userid'] ."'>Mio Post!</p>";
                             //$loadMess .= "<p><a href='#' class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</a></p>";
                        }
                        else
                        {
                            $foll_query = "SELECT * FROM Follow WHERE follower = ". $follower ." AND isFollowing = ". $isFollowing ." LIMIT 1"; 
                            $foll_result = mysqli_query($link, $foll_query);
                            if ( mysqli_num_rows($foll_result) > 0 )
                            {
                                
                                
                    //$loadMess .= "<p class='btn' class='toggleFollow' data-userId='". $isFollowing ."'>Non Seguire!!</p>";
                    //$loadMess .= "<button class='btn' class='toggleFollow' data-userId='". $isFollowing ."'>Non Seguire!!</button>";
                    //$loadMess .= "<button class='btn' class='toggleFollow' data-userId='". $isFollowing ."'>Non Seguire!!<span class='badge badge-secondary'>4</span></button>";
                    //$loadMess .= "<button class='btn' class='toggleFollow' data-userId='". $isFollowing ."'><span class='badge badge-secondary'>Non Seguire!!</span></button>";
                 
 

                                
                                
                            $loadMess .= "<p class='toggleFollow' data-userId='". $isFollowing ."'>Non Seguire!!</p>";
                              //$loadMess .= "<p class='toggleFollow' data-userId='". $isFollowing ."'>Non Seguire!</p>";
                                // $loadMess .= "<p><a href='' class='toggleFollow' data-userId='".$isFollowing."'>Non Seguire!</a></p>";
                            }
                            else
                            {
                                  $loadMess .= "<p class='toggleFollow' data-userId ='". $isFollowing ."'>Segui!!</p>";
                                //$loadMess .= "<p class='toggleFollow' data-userId='". $isFollowing ."'>Segui!</p>";
                                //$loadMess .= "<p><a href='' class='toggleFollow' data-userId='".$isFollowing."'>Segui!</a></p>";
                            }
                        }
                    }
                    $loadMess .= "</div>";    
                }  
                   
                    echo $loadMess;
            }
        }  // TIMELINE
        else if ( $_GET['page'] == 'following' ) {// FOLLOWING
            if ( $_SESSION ) { //  echo 'test';
                $loadMess = '';
                $follower = mysqli_real_escape_string($link, $_SESSION['id']); 
                $query = "SELECT * FROM Tweets 
                JOIN Follow ON Tweets.userid = Follow.isFollowing
                WHERE Follow.follower = " .$follower. "
                AND Tweets.id < ". $_GET['lastId'] ."
                ORDER BY Tweets.id DESC LIMIT 8";
                //ORDER BY Tweets.datetime DESC LIMIT 10";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) == 0) { echo false; }  else { 
                    $loadMess .= "<span class='badge badge-light'>Pagina ". $_GET['pageNum'] ."</span>"; // RITORNA IL NUMERO DI PAGINE VISUALIZZATE
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
        else if ( $_GET['page'] == 'profiles' ) {    //{ echo $_GET['userid']; }  // PROFILES if (  $_GET['userid'] )  { echo $_GET['userid'];  }   echo $_SERVER['REQUEST_URI'];
            if ( $_SESSION ) { //echo 'ciao';
                $loadMess = '';
                if ( !array_key_exists('userid', $_GET) ) // il profilo dell utente
                {//echo 'test1';
                    $userid = mysqli_real_escape_string($link, $_SESSION["id"]);
                    $query = "SELECT * FROM Tweets WHERE userid = ". $userid ." AND id < ". $_GET['lastId'] ." ORDER BY id DESC LIMIT 8"; //WHERE id < ". $_GET['lastId'] ." ORDER 
                    $result = mysqli_query($link, $query);
                    if (mysqli_num_rows($result) == 0) { echo false; } else {
                        $loadMess .= "<span class='badge badge-light'>Pagina ". $_GET['pageNum'] ."</span>"; // RITORNA IL NUMERO DI PAGINE VISUALIZZATE
                        while ( $row = mysqli_fetch_assoc($result) )
                        {   //$loadMess .= $row['id'] ."-";
                            $loadMess .= "<div class='tweet' lastId='". $row['id'] ."'>";
                            $loadMess .= "<span class='timeago'>Ho postato ". time_since2(time() - strtotime($row["datetime"])) ."</span>";
                            $loadMess .= "<p>". $row["tweet"] ."</p>";
                            $loadMess .= "</div>";       
                        } 
                    }
                }
                else // il profilo degli altri utenti
                { //echo 'test2';
                    $userid = mysqli_real_escape_string($link, $_GET['userid']);
                    $query = "SELECT * FROM Tweets WHERE userid = ". $userid ." AND id < ". $_GET['lastId'] ." ORDER BY id DESC LIMIT 8";
                    $result = mysqli_query($link, $query);
                    if (mysqli_num_rows($result) == 0) { echo false; } else {
                        $loadMess .= "<span class='badge badge-light'>Pagina ". $_GET['pageNum'] ."</span>"; // RITORNA IL NUMERO DI PAGINE VISUALIZZATE
                        while ( $row = mysqli_fetch_assoc($result) )
                        {
                            $user_query = "SELECT email FROM Users WHERE id = ". $userid ."";
                            $user_result = mysqli_query($link, $user_query); 
                            $user = mysqli_fetch_assoc($user_result);
                            $loadMess .= "<div class='tweet' lastId='". $row['id'] ."'>";
                            $loadMess .= "<p>". $user['email'] ."<span class='timeago'> ha postato ". time_since2(time() - strtotime($row["datetime"])) ." fa</span></p>"; 
                            $loadMess .= "<p>". $row["tweet"] ."</p>";
                            $loadMess .= "</div>";        
                        }
                    } //echo 'test';
                }
                echo $loadMess; 
            }   
        } // PROFILES
    }
?>