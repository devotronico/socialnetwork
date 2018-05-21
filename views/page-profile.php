
   <div class="container mainContainer">
    <div class="row">
         <div class="col-3" id="column-left">
        <div>
            <h2>column-left</h2>
             <?php
            
            
            
            include_once "App/Cartella/LoadPosts.php";

            $x = new nsLoadPosts\LoadPosts('profile');
            
            
            
            
            /*
            include_once('form-img.php'); 
            form per caricare foto personale
            dettagli dell utente
            ° nome
            ° email
            ° biografia
            ° provenienza
            ° data di iscrizione
            ° compleanno
            ° miniature immagini caricate
            */
            ?>
        </div>
    </div>
        <div class="col-6" id="column-center">
            <h2>profile</h2>
            <div id="colonnaPosts">
               <?php $return = $x->getArray(); ?>
                <?php /*$return = Profiles2();*/ ?>
                <?php include_once('posts.php'); ?>
                <?php //include_once('posts-pofiles.php'); ?> <!-- test funziona-->
               <?php// displayTweets("profiles");?> <!-- old-->
            </div>
        </div>
        <div class="col-3" id="column-right">
            <?php displaySearch();?>
            <?php displayTweetBox();?>
        </div>
    </div>
</div>