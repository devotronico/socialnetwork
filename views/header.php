<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css"> <!--CSS-->
    <script src="https://use.fontawesome.com/c058ff495b.js"></script> <!--FONTAWESOME-->

  </head>
  <body>
<!--------------------NAVBAR--------------------------------------------------------------------------------->
     <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="?page=home"><i class="fa fa-connectdevelop" aria-hidden="true"></i> Social Network</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-expand-lg navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-item nav-link" href="?page=timeline"><i class="fa fa-globe" aria-hidden="true"></i> Global Tweets</a>
      </li>
      <li class="nav-item">
        <a class="nav-item nav-link" href="?page=following"><i class="fa fa-users" aria-hidden="true"></i> Friends Tweets</a>
      </li>
      <li class="nav-item">
        <a class="nav-item nav-link" href="?page=profiles"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
      </li>
    </ul>
    <div class="form-inline my-2 my-lg-0">
    <?php ButtonHeader(); ?>
    </div>
  </div>
</nav>



