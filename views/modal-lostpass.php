<div class="modal fade" id="modalForgotPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleLogin">Recupera Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="message" id="message-recovery"></div>
        <form><!--- FORM ---------------------------------------------------------------------------------------------------------------->
              <div class="form-group">
            <label for="email-recovery" >Username o Email</label>
            <input type="text" class="form-control" id="email-recovery" aria-describedby="emailHelp" placeholder="Enter username o email">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
        <button type="button" class="btn btn-primary" id="recoveryPassBtn">Recupera Password</button>
      </div>
    </div>
  </div>
</div>
