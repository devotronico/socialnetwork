<div class="container mainContainer">
  <div class="row">
    <div class="col-sm-8">
      <h2>My Tweets</h2>
      <?php displayTweets("mytweets"); ?>
    </div>
    <div class="col-sm-4">
      <h2>Search</h2>
        <?php displaySearch(); ?>
        <?php displayTweetBox(); ?>
    </div>
  </div>
</div>