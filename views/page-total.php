<div class="container mainContainer">
  <div class="row">
    <div class="col-3" id="column-left">
        <div>
            <h2>column-left</h2>
        </div>
    </div>
    <div class="col-6" id="column-center">
      <h2>global act</h2>
       <div id="colonnaPosts">
        <?php
            include_once "App/Cartella/LoadPosts.php";
            $total = new nsLoadPosts\LoadPosts('total');
            $return = $total->getArray();
            include_once('posts.php');
        ?>
           
            <?php /*$return = Total2(); 
            include_once('posts.php'); */?>
            
           <?php // include_once('posts-total.php'); ?> <!-- test non funziona-->
          <?php// displayTweets("total"); ?>
        </div>
    </div>
    <div class="col-3" id="column-right">
          <?php displaySearch(); ?>
        <?php displayTweetBox(); ?>
    </div>
  </div>
</div>
 