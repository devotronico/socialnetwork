
<?php if ( is_array($return) ) : ?>
    <?php foreach($return as $a) : ?>
        <div class='tweet' lastId='<?=$a['id_post']?>'>
            <div class='tweet-left'>img</div>                                 
            <div class='tweet-right'>                
                <span class='timeago'>[<?=$a['id_post']?>]&nbsp;<a href='?page=profiles&userid=<?=$a['userid']?>'><?=$a['username']?></a></span>
                <span>&nbsp;ha&nbsp;pubblicato&nbsp;il&nbsp;suo&nbsp;post&nbsp;numero&nbsp;<?=$a['usernumtweet']?></span>
                <span>&nbsp;-&nbsp;<?=time_since(time()-strtotime($a['datetime']))?>&nbsp;ago</span>            
                <p><?=$a['tweet']?></p>   
            </div>
            <div class='tweet-clear'></div>
        </div> 
    <?php endforeach; ?>
    <button type="button" class="btn btn-primary btn-lg btn-block" id="buttonLoadMess">Carica altri messaggi</button>
<?php else : ?>
<div><p><?=$return?></p></div>
<?php endif; ?>