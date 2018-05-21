<!--- MODAL ---------------------------------------------------------------------------------------------------------------->
<div class="modal fade" id="modalAccedi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleLogin">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="message" id="message-signin"></div>
        <div id="loading"></div>
        <form><!--- FORM -------------------------------------------------------------------------------------------------->
              <div class="form-group">
            <label for="email-log" >Username o Email</label>
            <input type="email" class="form-control" id="email-log" aria-describedby="emailHelp" placeholder="Enter username o email">
          </div>
          <div class="form-group">
            <label for="password-log">Password</label>
            <input type="password" class="form-control" id="password-log" placeholder="Password">
            <small id="password-forgot" class="form-text text-muted" data-toggle="modal" data-target="#modalForgotPass" data-dismiss="modal">password dimenticata?</small>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;</button>
        <button type="button" class="btn btn-primary"  id="loginButton">Accedi</button>
      </div>
    </div>
  </div>
</div>







