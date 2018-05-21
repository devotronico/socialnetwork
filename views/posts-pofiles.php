<?php
//include_once("../functions-profile.php");
$return = Profiles2();
//print_r($return);
//var_dump($return);
//gettype($return);
?>
<!--id del post, userid del utente, usernumtweet del post, datetime del post, tweet del post, username utente-->
<?php if ( is_array($return) ) : ?>
<?php foreach($return as $a) : ?>
<div class='tweet' lastId="<?=$a['id']?>"> 
<div class='tweet-left'><img src='img/0.jpg' width='50px'></div>
<div class='tweet-right'>                
<span class='timeago'>[<?=$a['id']?>]&nbsp;<a href='?page=profiles&userid=<?=$a['userid']?>'><?=$a['username']?> </a>&nbsp;ha&nbsp;pubblicato&nbsp;il&nbsp;suo&nbsp;post&nbsp;numero&nbsp;<?=$a['usernumtweet']?>&nbsp;-&nbsp;<?=time_since(time()-strtotime($a['datetime']))?>&nbsp;ago</span>            
<p><?=$a['tweet']?></p>    
</div>
<div class='tweet-clear'></div>
</div>
<?php endforeach; ?>
<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>
<?php else : ?>
<div><p><?=$return?></p></div>
<?php endif; ?>




<!--
<div class='tweet' lastId='". $row['id'] ."'>
<p>".$user['username']."<span class='timeago'> ha postato il suo tweet numero ".$row['usernumtweet']." - ". time_since(time() - strtotime($row["datetime"])) ." ago</span></p> 
<p>". $row["tweet"] ."</p>
</div>  

<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>   
-->




<!--
<div class='tweet' lastId='". $tweet['id'] ."'>
<div class='tweet-left'><img src='img/0.jpg' width='50px'></div>;
<div class='tweet-right'>;

<span class='timeago'>[".$tweet['id']."] <a href='?page=profiles&userid=".$user["id"]."'>". $user['username'] ."</a>
ha postato il suo tweet numero ".$tweet['usernumtweet']." - ".time_since(time() - strtotime($tweet["datetime"]))." ago</span>            
<p>". $tweet["tweet"] ."</p>            


<p class='toggleFollow' data-userId='".$tweet['userid']."'><a href='#' class='follow-link'>mio post</a></p>
<p class='toggleFollow' data-userId=".$isFollowing."><a href='#' class='follow-link'>non seguire</a></p> 
<p class='toggleFollow' data-userId=".$isFollowing."><a href='#' class='follow-link'>segui</a></p>


</div>
<div class='tweet-clear'></div>
</div>

<button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>
-->

