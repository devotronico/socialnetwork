<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="?page=home"><i class="fab fa-connectdevelop"></i>&nbsp;Social Network</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-expand-lg navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-item nav-link" href="?page=total"><i class="fas fa-globe"></i>&nbsp;global posts</a>
      </li>
      <li class="nav-item">
        <a class="nav-item nav-link" href="?page=following"><i class="fas fa-users"></i>&nbsp;friends posts</a>
      </li>
      <li class="nav-item">
        <a class="nav-item nav-link" href="?page=profiles"><i class="fas fa-user"></i>&nbsp;profile</a>
      </li>
    </ul>
          <form class="form-inline my-2 my-lg-0">
            <?php if ( isset($_SESSION["id"]) ) : ?>
            <p>Benvenuto&nbsp;<?=$_SESSION["username"]?>&nbsp;</p>
            <a class="btn btn-danger" href="?page=logout" role="button">Logout</a>
            <?php else: ?>
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalAccedi">Accedi</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalReg">Registrati</button>
            <?php endif ?>
        </form>
  </div>
</nav>

   
  





