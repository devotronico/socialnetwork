<div class="verify-newpass">
    <h5>Imposta nuova password</h5>
<div class="message" id="message-newpass"></div>
    <form>
        <input type="hidden" name="newpass-email" id="newpass-email" value="<?=$_GET['email']?>">    
        <input type="hidden" name="newpass-hash" id="newpass-hash" value="<?=$_GET['hash']?>">
        <div class="form-group">
            <label for="new-password">Nuova password</label>
            <input type="password" class="form-control" id="new-password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="conf-new-password">Conferma nuova password</label>
            <input type="password" class="form-control" id="conf-new-password" placeholder="Conferma Password">
        </div>
    </form>
    <div class="div-float-right">
        <button type="button" class="btn btn-primary" id="newPassButton">Salva</button>
    </div>
    <div class="div-float-clear"></div>
</div>     
       
        