<div class="container mainContainer">
  <div class="row">
    <div class="col-sm-8" id="colonnaMessaggi">
      <h2>Global Tweets</h2>
      <?php displayTweets("public"); ?>
    </div>
    <div class="col-sm-4">
          <?php displaySearch(); ?>
        <?php displayTweetBox(); ?>
    </div>
  </div>
</div>
 