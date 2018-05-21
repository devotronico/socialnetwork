<!--- MODAL ---------------------------------------------------------------------------------------------------------------->
<div class="modal fade" id="modalReg" tabindex="-1" role="dialog" aria-labelledby="registrazioneLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleLoginSignup">Registrazione</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="message" id="message-signup"></div>
        <div id="loading"></div>
        <form><!--- FORM ---------------------------------------------------------------------------------------------------------------->
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email-reg" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password-reg" placeholder="Password">
          </div>
            <div class="form-group">
            <label for="password">Conferma Password</label>
            <input type="password" class="form-control" id="confirm_password" placeholder="Conferma Password">
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="checkbox" class="form-check-input">
              Check me out
            </label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
        <button type="button" class="btn btn-primary"  id="signupButton">Registrati</button>
      </div>
    </div>
  </div>
</div>

<!-- PASSWORD SCRIPT
<form namRune="Login" method="post" action="">
    <fieldset>
        <legend>Password Strength</legend>        
        <input type="password" name="pass" id="pass">
        <span id="passstrength"></span>
    </fieldset>
</form>  
-->

