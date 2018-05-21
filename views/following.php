<div class="container mainContainer">
  <div class="row">
     <div class="col-sm-8" id="colonnaMessaggi">
      <h2>Friends Tweets</h2>
      <?php displayTweets("following"); ?>
    </div>
    <div class="col-sm-4">
        <?php displaySearch(); ?>
        <?php displayTweetBox(); ?>
    </div>
  </div>
</div>