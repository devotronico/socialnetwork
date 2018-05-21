<!--- FOOTER ----------------------------------------------------------------------------------------------------------
<footer class="footer">
  <div class="container">
    <p>&copy; My Website 2017</p>
  </div>
</footer>
    ------> 
<!--- MODAL ---------------------------------------------------------------------------------------------------------------->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleLoginSignup">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div id="message"></div>
        <form><!--- FORM ---------------------------------------------------------------------------------------------------------------->
<!--          <input type="hidden" id="loginActive" name="loginActive" value="1">-->
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
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
<!--        <div id="toggleLogin">SignUp</div>    -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
<!--        <button type="button" class="btn btn-primary"  id="loginSignupButton">Login</button>-->
        <button type="button" class="btn btn-primary"  id="loginButton">Accedi</button>
        <button type="button" class="btn btn-primary"  id="signupButton">Registrati</button>
      </div>
    </div>
  </div>
</div>
    
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    
    <script>
       
        $('#loginButton').click(function(){  
            $.ajax({
                type: "POST",
                dataType: "text", 
                url: "actions.php/?action=loginSignup",
                data: { email: $('#email').val(), password: $('#password').val(), loginActive: 'accedi' },
                success: function(result)
                {
                    if ( result == "Loggato" )
                    { //$("#message").html('<div class="alert alert-success" role="alert"> '+ result +' </div>'); 
                        //alert('ok');
                        window.location.assign("http://danielemanzidomain-com.stackstaging.com/socialnetwork/?page=timeline");
                    }
                    else
                    {
                         $("#message").html('<div class="alert alert-danger" role="alert"> '+ result +' </div>');  
                    }
                }
            })
        });  // LOGIN/ACCESSO
        
        $('#signupButton').click(function(){  
            $.ajax({
                type: "POST",
                dataType: "text", 
                url: "actions.php/?action=loginSignup",
                data: { email: $('#email').val(), password: $('#password').val(), loginActive: 'registrati' },
                success: function(result)
                {
                    if ( result == "Registrato" )
                    { // $("#message").html('<div class="alert alert-primary" role="alert"> '+ result +' </div>'); 
                        window.location.assign("http://danielemanzidomain-com.stackstaging.com/socialnetwork/?page=timeline");
                    }
                    else
                    {
                         $("#message").html('<div class="alert alert-danger" role="alert"> '+ result +' </div>');  
                    }
                }
            })
        }); // SIGNUP/REGISTRAZIONE
        
        $(document).on('click', '.toggleFollow', function(){ 
               var id = $(this).attr('data-userId');
            $.ajax({
                type: "POST",
                url: "actions.php/?action=toggleFollow",
                data: { userId: id },
                success: function(result)
                {
                    $("p[data-userId='"+id+"']").html(result);  
                }
            });
        }); // SEGUI/NON SEGUIRE/MIO POST

        /*
        $('.toggleFollow').click(function(){ alert('ok');
            var id = $(this).attr('data-userId');
            $.ajax({
                type: "POST",
                url: "actions.php/?action=toggleFollow",
                data: { userId: id },
                success: function(result)
                {
                    $("p[data-userId='"+id+"']").html(result);  
                }
            });
        }); // SEGUI/NON SEGUIRE/MIO POST
        */
        
        
        $('#postButton').click(function(){ 
                $.ajax({
                type: "POST",
                url: "actions.php/?action=postTweet",
                data: { contentTweet: $('#textareaId').val() },
                success: function(result)
                { 
                    if ( result == '1' )
                    {
                        window.location.assign("http://danielemanzidomain-com.stackstaging.com/socialnetwork/?page=timeline");
                    }
                    else
                    {
                        alert(result);
                    }
                }
            });
        });
        
        var pageNum = 0;
        $('#buttonLoadMess').click(function(){
            var lastId = $( ".tweet:last-of-type" ).attr('lastId'); //alert(id);
            var userid = $('#buttonLoadMess').val(); 
            pageNum += 8;
            var url = $(location).attr('href');
            switch ( url )
            {
                case 'http://danielemanzidomain-com.stackstaging.com/socialnetwork/?page=timeline' : url = 'timeline'; break;    
                case 'http://danielemanzidomain-com.stackstaging.com/socialnetwork/?page=following' : url = 'following'; break; 
                default : url = 'profiles';
            } // alert(url);  // var pathname = window.location.pathname; ->Returns path only  ||| var url = window.location.href; ->Returns full URL
            //alert(userid);
           $.ajax({
               type: "GET",
               url: "actions.php/?action=carica",
               data: {lastId: lastId, page: url, userid: userid, pageNum: pageNum}, // [!]  
               beforeSend:  function() {
                  $('#buttonLoadMess').html('<img src="loader.gif"/>');
               },
               success: function(result){ 
                   if ( !result) 
                   {  //alert('false');
                       $('#buttonLoadMess').html('Fine');
                   }
                   else
                   {   //alert(result); //alert('prova');
                       $( '#buttonLoadMess').hide();
                       $( '#colonnaMessaggi' ).append(result);
                       $( '#buttonLoadMess').html('Carica');
                       $( '#colonnaMessaggi' ).append( $('#buttonLoadMess').show());
                       //$( '#pageNumClass' ).append( $('#buttonLoadMess').show());
                    } 
               },
               error: function (xhr, textStatus, error) {
                   console.log(xhr);
                   console.log(textStatus);
                   console.log(error);
               }
           })
       });
    </script>
  </body>
</html>