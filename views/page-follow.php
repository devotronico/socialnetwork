<div class="container mainContainer">
   <div class="row">
      <div class="col-3" id="column-left">
         <div>
            <h2>column-left</h2>
         </div>
      </div>
      <div class="col-6" id="column-center">
         <h2>friends act</h2>
         <div id="colonnaPosts">
            <?php 
                   
            include_once "App/Cartella/LoadPosts.php";

            $f = new nsLoadPosts\LoadPosts('follow');
            $return = $f->getArray();
             
             ?>
            <?php /*$return = Follow2();*/ ?>
            <?php include_once('posts.php'); ?>
            <?php //include_once('posts-follow.php'); ?> <!-- test non funziona-->
         </div>
      </div>
      <div class="col-3" id="column-right">
         <?php  displaySearch(); ?>
         <?php  displayTweetBox(); ?>
      </div>
   </div>
</div>


 