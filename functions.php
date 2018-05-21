<?php
    if ( array_key_exists('page', $_GET ) ) {
        if ( $_GET['page'] == "logout")
        {
            session_unset();
            //header("Location: index.php");
        }
    }

    function ButtonHeader(){
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
} // BOTTONE PER LOGIN/SIGN/LOGOUT

    function displaySearch(){
        echo '<form class="form-inline" id="searchForm">
                <div class="form-group">
                  <input type="hidden" name="page" value="search">
                  <input type="text" class="form-control" name="query" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-primary" id="buttonSearch"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
             </form>';
    } 

    function displayTweetBox(){
        if ( $_SESSION ) // ( $_SESSION['id'] > 0 )
        {
            echo '<div class="form" id="postForm">
                    <div class="form-group">
                      <textarea class="form-control" id="textareaId" rows="3" placeholder="Write Something"></textarea>
                    </div>
                    <button class="btn btn-primary" id="postButton"><i class="fa fa-pencil" aria-hidden="true"></i> Post</button>
                  </div>';
        }
    }   // check

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

} // check

    function publicTweet(){
        global $link;
        $query = "SELECT * FROM Tweets ORDER BY id DESC LIMIT 8";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) == 0)
        {
            echo "Non ci sono tweets da mostrare";
        }
        else
        {
          /*  function FollowLink($test) {
                $link = $test;
                    $follower = mysqli_real_escape_string($link, $_SESSION['id']); //  FOLLOW LINK start
                    $isFollowing = mysqli_real_escape_string($link, $row["userid"]);
                    if ( $follower == $isFollowing )
                    {
                        echo "<p class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</p>";
                    }
                    else
                    {
                        $foll_query = "SELECT * FROM Follow WHERE follower = ". $follower ." AND isFollowing = ". $isFollowing ." LIMIT 1"; 
                        $foll_result = mysqli_query($link, $foll_query);
                        if ( mysqli_num_rows($foll_result) > 0 )
                        {
                            echo "<p class='toggleFollow' data-userId='".$isFollowing."'>Non Seguire!</p>";
                        }
                        else
                        {
                            echo "<p class='toggleFollow' data-userId='".$isFollowing."'>Segui!</p>";
                        }
                    } //  FOLLOWLINK end
            } */ // FUNZIONE DA SVILUPPARE
            while ( $row = mysqli_fetch_assoc($result) )
            {
                $user_query = "SELECT email FROM Users WHERE id = ".mysqli_real_escape_string($link, $row["userid"])."";
                $user_result = mysqli_query($link, $user_query); 
                $user = mysqli_fetch_assoc($user_result);
                echo "<div class='tweet' lastId='". $row['id'] ."'>";
echo "<p><a href='?page=profiles&userid=".$row["userid"]."'>". $user['email'] ."</a><span class='timeago'> ha postato ". time_since(time() - strtotime($row["datetime"])) ." fa</span></p>"; 
                echo "<p>". $row["tweet"] ."</p>";

                 // SEGUI / NON SEGUIRE / MIO POST 
                if ( $_SESSION ) // ( isset($_SESSION) )
                {  //FollowLink($link); // FUNZIONE DA SVILUPPARE
                    $follower = mysqli_real_escape_string($link, $_SESSION['id']); //  FOLLOWLINK start
                    $isFollowing = mysqli_real_escape_string($link, $row["userid"]);
                    if ( $follower == $isFollowing )
                    {
                        echo "<p class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</p>";
                         //echo "<p><a href='#' class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</a></p>";
                    }
                    else
                    {
                        $foll_query = "SELECT * FROM Follow WHERE follower = ". $follower ." AND isFollowing = ". $isFollowing ." LIMIT 1"; 
                        $foll_result = mysqli_query($link, $foll_query);
                        if ( mysqli_num_rows($foll_result) > 0 )
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
                }
                echo "</div>";  
            }
            //echo "<div class='pageNumClass'>8</div>"; //echo "<div class='pageNumClass' pageNumAttr='". $pageNum ."'>8</div>"; // [!]
            echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>';
        }
}  // check

    function following(){
        if ( $_SESSION )
        {
            global $link;
            $follower = mysqli_real_escape_string($link, $_SESSION['id']); 
            $query = "SELECT * FROM Tweets 
            JOIN Follow ON Tweets.userid = Follow.isFollowing
            WHERE Follow.follower = ".$follower."
            ORDER BY Tweets.id DESC LIMIT 8";
            //ORDER BY Tweets.datetime DESC LIMIT 10";
            $result = mysqli_query($link, $query);
            if ( mysqli_num_rows($result) > 0 )
            {
                while ( $row = mysqli_fetch_assoc($result) )
                {
                    $friend = mysqli_real_escape_string($link, $row['userid']); 
                    $user_query = "SELECT email FROM Users WHERE id = ".$friend."";
                    $user_result = mysqli_query($link, $user_query); 
                    $user = mysqli_fetch_assoc($user_result);
                    echo "<div class='tweet' lastId='". $row['id'] ."'>";
echo "<p><a href='?page=profiles&userid=".$row["userid"]."'>". $user['email'] ."</a><span class='timeago'> ha postato ". time_since(time() - strtotime($row["datetime"])) ." fa</span></p>";
                    //echo "<p>". $user['email'] ."<span class='timeago'> ha postato ". time_since(time() - strtotime($row["datetime"])) ." fa</span></p>"; 
                    echo "<p>". $row["tweet"] ."</p>";
                    
                                       
                    $follower = mysqli_real_escape_string($link, $_SESSION['id']); //  FOLLOWLINK start
                    $isFollowing = mysqli_real_escape_string($link, $row["userid"]);
                    if ( $follower == $isFollowing )
                    {
                        echo "<p class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</p>";
                         //echo "<p><a href='#' class='toggleFollow' data-userId='".$row['userid']."'>Mio Post!</a></p>";
                    }
                    else
                    {
                        $foll_query = "SELECT * FROM Follow WHERE follower = ". $follower ." AND isFollowing = ". $isFollowing ." LIMIT 1"; 
                        $foll_result = mysqli_query($link, $foll_query);
                        if ( mysqli_num_rows($foll_result) > 0 )
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
    }  // check

    function profiles(){
        if ( $_SESSION )
        {
            global $link;
            if ( !array_key_exists('userid', $_GET) ) // il profilo degli altri utenti
            {
                $id = mysqli_real_escape_string($link, $_SESSION["id"]);
                $query = "SELECT * FROM Tweets WHERE userid = ". $id ." ORDER BY datetime DESC LIMIT 8";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) == 0)
                {
                    echo "Non hai ancora pubblicato dei Tweets";
                }
                else
                {
                    while ( $row = mysqli_fetch_assoc($result) )
                    {
                        echo "<div class='tweet' lastId='". $row['id'] ."'>";
                        echo "<span class='timeago'>Ho postato ". time_since(time() - strtotime($row["datetime"])) ."</span>";
                        echo "<p>". $row["tweet"] ."</p>";
                        echo "</div>";        
                    }
                }
                echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess" value="'. $_SESSION["id"] .'" >Carica altri messaggi</button>';
            }
            else // il profilo dell utente
            {//testUserid = $_GET['userid'];
                $id = mysqli_real_escape_string($link, $_GET['userid']);
                $query = "SELECT * FROM Tweets WHERE userid = ". $id ." ORDER BY datetime DESC LIMIT 8";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) == 0)
                {
                    echo "Non ha ancora pubblicato dei Tweets";
                }
                else
                {
                    while ( $row = mysqli_fetch_assoc($result) )
                    {
                        $user_query = "SELECT email FROM Users WHERE id = ".mysqli_real_escape_string($link, $row["userid"])."";
                        $user_result = mysqli_query($link, $user_query); 
                        $user = mysqli_fetch_assoc($user_result);
                        echo "<div class='tweet' lastId='". $row['id'] ."'>";
                        echo "<p>". $user['email'] ."<span class='timeago'> ha postato ". time_since(time() - strtotime($row["datetime"])) ." fa</span></p>"; 
                        //echo "<span class='timeago'>Ha postato ". time_since(time() - strtotime($row["datetime"])) ."</span>";
                        echo "<p>". $row["tweet"] ."</p>";
                        echo "</div>";        
                    }
                } 
                echo '<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess" value="'. $_GET['userid'] .'" >Carica altri messaggi</button>';
            }
            
        }
        else
        {
            echo "<p>Loggati o iscriviti per pubblicare i tuoi Tweet!</p>";
        }  
    }  // check

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
    } 

    function displayTweets($type){
        switch ( $type )
        {
            case "public"    : publicTweet(); break;
            case "following" : following();   break;
            case "profiles"  : profiles();    break;
            case "search"    : search();      break;
        }
    }  // check

?>




