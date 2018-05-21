<?php 
if ( isset($_GET['id']) ) {
$test = $_GET['userid'];
    
}
else if ( isset($_SESSION["id"]) )
{
 $test = $_SESSION["id"];    
}
else
{
    die('errore nel file (form-img-php)');
}
?>





<form enctype="multipart/form-data" method="post" action="../actions/update.php">
   <div class="form-group">
       <img id="thumbnail" width="<?=MAX_FILE_WIDTH?>" height="<?=MAX_FILE_HEIGHT?>" src="<?=empty($user['image'])?IMAGE_DIR.'0.jpg':IMAGE_DIR.$user['image']?>"  alt="immagine di profilo">
    </div>
      
      <input type="hidden" name="MAX_FILE_SIZE" value="<?=MAX_FILE_SIZE?>" />
        
        <div class="form-group">
            <label for="avatar">immagine del profilo</label>
            <div class="input-group mb-2 mb-sm-0">
                <div class="input-group-addon"><i class="fas fa-file-image"></i></div>
<input type="file" onchange="previewFile(this)" class="form-control" id="avatar" placeholder="Avatar" name="avatar" value="<?=$user['image']?>" accept="image/jpeg">
            </div>
        </div>
        
        <a class="btn btn-danger" href="update.php?action=delete&amp;<?=$queryString?>&amp;id=<?=$user['id']?>">ELIMINA</a>
        <button type="submit" class="btn btn-primary">AGGIORNA</button>
</form>

