<?php
namespace nsLoadPosts;
    
    
class LoadPosts{
    private $id;
    private $canLoad;
    private $sql;
    
    public function __construct(string $page='')
    {
        switch( $page )
        {
            case 'profile':
            if ( $_SESSION )
            {
                $this->canLoad = true;  
           
                if ( array_key_exists('userid', $_GET) ) 
                {
                    $this->id = (int)$_GET['userid']; // il profilo degli altri utenti
                }
                else    
                {
                    $this->id = (int)$_SESSION["id"]; // il profilo dell' utente
                }

                $_SESSION['otherid'] = $this->id;

                $this->sql = "SELECT Tweets.*,Users.id, Users.username, Users.image
                FROM Users, Tweets
                WHERE Users.id = $this->id 
                AND Tweets.userid = $this->id
                ORDER BY Tweets.id_post
                DESC LIMIT ". MAXLOADTWEET;
            }
            break;                   
            case 'follow':
                if ( $_SESSION )
                {
                    $this->canLoad = true;
                    if ( !array_key_exists('userid', $_GET) ) 
                    {
                        $this->id = (int)$_SESSION["id"]; // il profilo dell' utente
                    }
                    $this->sql = "SELECT * FROM Follow
                    INNER JOIN Tweets 
                    ON Tweets.userid = Follow.following
                    INNER JOIN Users 
                    ON Users.id = Follow.following
                    WHERE Follow.follower = $this->id
                    ORDER BY Tweets.id_post
                    DESC LIMIT ". MAXLOADTWEET;    
                }
            break;
            case 'total':
                $this->canLoad = true;  
                $this->sql = "SELECT Tweets.*, Users.username, Users.image 
                FROM Tweets
                INNER JOIN Users
                ON Users.id = Tweets.userid
                ORDER BY Tweets.id_post
                DESC LIMIT ". MAXLOADTWEET;
            break;
            default: echo'nessun parametro';
        }
    }

        

    public function getArray(){     
                 
            if ( $this->canLoad )
            {   
                $mysqli = $GLOBALS['mysqli'];
                $res = $mysqli->query($this->sql);   //echo '<pre>', var_dump($res) ,'</pre>';
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

    }      
}