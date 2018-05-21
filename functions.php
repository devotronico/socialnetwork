<?php
if ( array_key_exists('page', $_GET ) ) {
    if ( $_GET['page'] == "logout")
    {
        session_unset();
        //header("Location: index.php");
    }
}

/*******SEARCH*********************************************************************************************************************/
function displaySearch(){
        echo '<form class="form-inline" id="searchForm">
            <div class="message" id="message-search"></div>
                <div class="form-group">
                  <input type="hidden" name="page" value="search">
                  <input type="text" class="form-control" name="query" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-primary" id="buttonSearch"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
             </form>';
    } /// SEARCH 

function search() {
        global $link;
        $cerca = mysqli_real_escape_string($link, $_GET['query']);
        echo "<p>Mostra i risultati per la parola: <b>".$cerca."</b></p>";
        $query = "SELECT * FROM Tweets WHERE tweet LIKE '%". $cerca ."%' LIMIT 10";
        $result = mysqli_query($link, $query);
        if ( mysqli_num_rows($result) > 0 )
        {
            while ( $row = mysqli_fetch_assoc($result) )
            {
                $user_query = "SELECT email FROM Users WHERE id = ".mysqli_real_escape_string($link, $row["userid"])."";
                $user_result = mysqli_query($link, $user_query); 
                $user = mysqli_fetch_assoc($user_result);
                echo "<div class='tweet'>";
                echo "<p>". $user['email'] ."<span class='timeago'> ha postato ". time_since(time() - strtotime($row["datetime"])) ." fa</span></p>"; 
                $tweet = str_ireplace($cerca, "<b>". $cerca ."</b>", $row["tweet"]);
                echo "<p>". $tweet ."</p>";

                 // SEGUI / NON SEGUIRE / MIO POST /
                if ( $_SESSION ) // ( isset($_SESSION) )
                {
                    $follower = mysqli_real_escape_string($link, $_SESSION['id']);
                    $isFollowing = mysqli_real_escape_string($link, $row["userid"]);
                    if ( $follower == $isFollowing )
                    {
                         echo "<p><a href='#' class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</a></p>";
                    }
                    else
                    {
                        $foll_query = "SELECT * FROM Follow WHERE follower = ". $follower ." AND isFollowing = ". $isFollowing ." LIMIT 1"; 
                        $foll_result = mysqli_query($link, $foll_query);
                        if ( mysqli_num_rows($foll_result) > 0 )
                        {
                            echo "<p><a href='#' class='toggleFollow' data-userId='".$isFollowing."'>Non Seguire!</a></p>";
                        }
                        else
                        {
                            echo "<p><a href='#' class='toggleFollow' data-userId='".$isFollowing."'>Segui!</a></p>";
                        }
                    }
                }
                echo "</div>";
            }
        }
        else
        {
            echo "<p>la ricerca non ha ottenuto risultati</p>";
        }
    } /// SEARCH
/*****************************************************************************************************************************/
function displayTweetBox(){
if ( $_SESSION['id'] ) 
{
echo '<div class="form" id="postForm">
        <div class="form-group">
          <textarea class="form-control" id="textareaId" rows="3" placeholder="scrivi qualcosa..."></textarea>
        </div>
        <div class="message" id="message-posttweet"></div>
        <button type="button" class="btn btn-primary" id="postButton"><i class="fas fa-share"></i>&nbsp;Post</button>
      </div>';
} 
}   /// TWEET BOX

function time_since($since) {
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
        
// NOW() 10/5/2017 3:36:27 PM 

// 2017-10-03 22:40:28

//DATE - format YYYY-MM-DD
 //   DATETIME - format: YYYY-MM-DD HH:MI:SS
//TIMESTAMP - format: YYYY-MM-DD HH:MI:SS

} // TIME

/*
function Total(){
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
*/// TOTAL
/*
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
*/// FOLLOW
/*
function Profiles(){
    if ( $_SESSION )
    {
        $mysqli = $GLOBALS['mysqli'];
        if ( !array_key_exists('userid', $_GET) ) // il profilo dell' utente
        {
            $id = (int)$_SESSION["id"]; 
            $result = $mysqli->query("SELECT * FROM Tweets WHERE userid = ". $id ." ORDER BY datetime DESC LIMIT ".MAXLOADTWEET);  //[!]
            if ( $result->num_rows === 0 )
            {
                echo "<span style='text-align:center;color:red'>Non hai <strong>ancora</strong> pubblicato dei Tweets</span>";
            }
            else
            {
                while ( $row = $result->fetch_assoc() )
                {
                    echo "<div class='tweet' lastId='". $row['id'] ."'>";  //[!]
echo "<span class='timeago'>[".$row['id']."] ho postato il mio tweet numero ".$row['usernumtweet']." - ".time_since(time()-strtotime($row["datetime"]))." ago</span>";   
                    echo "<p>". $row["tweet"] ."</p>";
                    echo "</div>";        
                }
                echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>';
            }
        }
        else // il profilo degli altri utenti
        {
            $userid = (int)$_GET['userid'];
            $result = $mysqli->query("SELECT * FROM Tweets WHERE userid = ". $userid ." ORDER BY datetime DESC LIMIT ".MAXLOADTWEET); 
            if ($result->num_rows === 0)
            {
                echo "".$user['username']."Non ha ancora pubblicato dei Tweets"; //[!]
            }
            else
            {
                $id = (int)$row["userid"];
                $user_result = $mysqli->query("SELECT email FROM Users WHERE id = ". $id );  //[!]
                $user = $user_result->fetch_assoc();
                while ( $row = $result->fetch_assoc() )
                {
//                        $user_query = "SELECT email FROM Users WHERE id = ".$mysqli->escape_string($row["userid"])."";
//                        $user_result = $mysqli->query($user_query); 
//                        $user = $mysqli->fetch_assoc($user_result);
                    echo "<div class='tweet' lastId='". $row['id'] ."'>";
echo "<p>".$user['username']."<span class='timeago'> ha postato il suo tweet numero ".$row['usernumtweet']." - ". time_since(time() - strtotime($row["datetime"])) ." ago</span></p>"; 
                    //echo "<span class='timeago'>Ha postato ". time_since(time() - strtotime($row["datetime"])) ."</span>";
                    echo "<p>". $row["tweet"] ."</p>";
                    echo "</div>";        
                }
//echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess" value="'. $_GET['userid'] .'" >Carica altri messaggi</button>';
               echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>';     
            } 
        }
    }
    else
    {
        echo "<p>Loggati o iscriviti per pubblicare i tuoi Tweet!</p>";
    }  
}  /// PROFILO
*/// PROFILES
function displayTweets($page){
    switch ( $page )
    {
        case "total"    : Total();    break;
        case "following" : Follow(); break;
        case "profiles"  : Profiles();  break;
        case "search"    : search();    break;
    }
}  // check



/*

function getFromGet($param,  $default=null, $type='string'){
    
    if($type === 'int'){
        $param = intval(filter_input(INPUT_GET, $param, FILTER_SANITIZE_NUMBER_INT));
    } else {
        $param = filter_input(INPUT_GET, $param, FILTER_SANITIZE_STRING)  ;
    }
    
    $ret = $param? $param : $default;
    
    return $ret;
}
*/
 /*   function ButtonHeader(){
    if ( isset($_SESSION["id"]) )
    { 
        global $link;
        $user_query = "SELECT * FROM Users WHERE id = ". mysqli_real_escape_string($link, $_SESSION["id"]) ." LIMIT 1";
        $user_result = mysqli_query($link, $user_query); 
        $user = mysqli_fetch_assoc($user_result);
        
        echo '<p id="welcomeUser">Ciao '. $user["email"] .'</p>';        
        echo '<a class="btn btn-outline-success my-2 my-sm-0" href="?page=logout">Logout</a>';  
    } 
    else
    {
         echo '<button class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">Login/SignUp</button>';
    } 
} */// BOTTONE PER LOGIN/SIGN/LOGOUT
?>




