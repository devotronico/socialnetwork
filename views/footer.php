    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    
    <script>
//LOGIN REGISTRAZIONE E RECUPERO PASSWORD------------------------------------            
$('#loginButton').click(function(){  
            $.ajax({
                type: "POST",
                dataType: "text", 
                url: "actions/action-login.php",
                data: { email: $('#email-log').val(), password: $('#password-log').val() },
                beforeSend:  function() {
                    $('#loading').html('<img src="img/loader.gif"/>').css({"text-align":"center"});
                },
                success: function(result)
                {
                   $('#loading').hide();
                    result = result.trim();
                    var char = result.substring(0,1);
                    switch (char)
                    {
                        case 'A': 
                            $("#message-signin").html('<div class="alert alert-success" role="alert">' + result +'</div>');
                            $('#loginButton').html('<img src="img/loader.gif" width="22px"/>&nbsp;Salva').css({"text-align":"center"}).attr("disabled", true);
                            setTimeout(function(){
                            window.location.assign("http://www.danielemanzi.it/2-socialnetwork");
                            },2500)    
                        break;
                        case 'L': 
                            $("#message-signin").html('<div class="alert alert-danger" role="alert">' + result + '</div>');
                        break;
                        case 'Q': 
                            $("#message-signin").html('<div class="alert alert-danger" role="alert">' + result + '</div>');
                        break;
                        case 'P': 
                            $("#message-signin").html('<div class="alert alert-danger" role="alert">' + result + '</div>');
                        break;
                        default: alert('errore sconosciuto!');
                    }            
                },
                error: function()
                {
                    alert("Chiamata fallita!!!");
                } 
            })
        });  // LOGIN/ACCESSO
        
$('#signupButton').click(function(){   
            $.ajax({
                type: "POST",
                dataType: "text", 
                url: "actions/action-signup.php",
                data: { username: $('#username').val(), email: $('#email-reg').val(), password: $('#password-reg').val(), confirm_password: $('#confirm_password').val() },
                beforeSend:  function() {
                    $('#loading').html('<img src="img/loader.gif"/>').css({"text-align":"center"});
                },
                success: function(result)
                {
                    $('#loading').hide();
                    result = result.trim();
                    var char = result.substring(0,1);
                    switch (char)
                    {
                        case 'U': 
                            $("#message-signup").html('<div class="alert alert-success" role="alert">' + result +'</div>');
                            $('#signupButton').html('Salva...').css({"text-align":"center"}).attr("disabled", true);
                        break;
                        case 'C': 
                            $("#message-signup").html('<div class="alert alert-danger" role="alert">' + result + '</div>');
                        break;
                        case 'Q': 
                            $("#message-signup").html('<div class="alert alert-danger" role="alert">' + result + '</div>');
                        break;
                        default: alert('errore sconosciuto!');
                    }            
                },
                error: function()
                {
                    alert("Chiamata fallita!!!");
                } 
            })
        }); // SIGNUP/REGISTRAZIONE
        
$('#recoveryPassBtn').click(function(){ 
        $.ajax({
            type: "POST",
            datatype: "text",
            url: "actions/action-recoverypass.php",
            data: { email: $('#email-recovery').val() },
            success: function(result)
            {
                result = result.trim();
                var char = result.substring(0,1);
                switch (char)
                {
                    case 'T':
                        $("#message-recovery").html('<div class="alert alert-success" role="alert">' + result +'</div>');
                        $('#recoveryPassBtn').html('Reupera password...').css({"text-align":"center"}).attr("disabled", true);
                    break;
                    case 'I':
                        $("#message-recovery").html('<div class="alert alert-danger" role="alert">' + result + '</div>');
                    break;
                    case 'Q': 
                        $("#message-recovery").html('<div class="alert alert-danger" role="alert">' + result + '</div>');
                    break;
                    default: alert('errore sconosciuto!');
                }
            },
            error: function()
            {
                alert("Chiamata fallita!!!");
            } 
        })
    }); // RESETTA PASSWORD 

$('#newPassButton').click(function(){  
        var email = $('#newpass-email').val(); var hash = $('#newpass-hash').val(); console.log(email); console.log(hash);
        $.ajax({
            type: "POST",
            data: {email: $('#newpass-email').val(), hash: $('#newpass-hash').val(), newpassword: $('#new-password').val(), confirmpassword: $('#conf-new-password').val() },
            datatype: "text",
            url:"actions/action-newpass.php",
            success: function(result)
            {
                result = result.trim();
                var char = result.substring(0,1);
                if (char === 'H')
                {
                    $("#message-newpass").html('<div class="alert alert-success" role="alert">' + result +'</div>');
                    $('#newPassButton').html('<img src="img/loader.gif" width="22px"/>&nbsp;Salva...').css({"text-align":"center"}).attr("disabled", true);
                    setTimeout(function(){
                    window.location.assign("http://www.danielemanzi.it/2-socialnetwork");
                    },1800)    
                }
                else
                {
                     $("#message-newpass").html('<div class="alert alert-danger" role="alert">' + result +'</div>');
                }           
            },
            error: function()
            {
                alert("Chiamata fallita!!!");
            } 
        })
    }); // SALVA NUOVA PASSWORD
        
        
//TASKS--------------------------------TASKS-----------------------------------------TASKS        
          
var button = $('#postButton');
var textarea = $('#textareaId');
button.attr('disabled', true);
textarea.on("keyup", function() {
    var disabled = false;
    if (!$.trim($(this).val())) { disabled = true; }
    button.attr('disabled', disabled);
}); /// DISATTIVA E ATTIVA IL BOTTONE POST

        
          
$('#postButton').click(function(){ 
$.ajax({
type: "POST",
url: "tasks/task-posttweet.php",
data: { contentTweet: $('#textareaId').val() },
success: function(response)
{ 
     
    var res = response;
    var char = res.trim();
    char = char.charAt(0);
    console.log(char); console.log(res);console.log( response ); 
    switch (char)
    {
        case 'S': 
        $("#message-posttweet").html('<div class="alert alert-danger" role="alert">' + res + '</div>');
        break;
        case 'N': 
        $("#message-posttweet").html('<div class="alert alert-danger" role="alert">' + res + '</div>');
        break;
        case 'I': 
        $("#message-posttweet").html('<div class="alert alert-danger" role="alert">' + res + '</div>');
        break;
        default: 

        //console.log(response);
        var html ='';      
        var risultato = response;
        var a = JSON.parse(risultato);
          console.log( a );  
     //   for(var i=0;i<a.length;i++)
     //   { console.log(a[i]);
            var i = 0;
            html += "<div class='tweet' lastId='"+a[i].id_post+"'>" 
            html += "<div class='tweet-left'>img</div>"                                 
            html += "<div class='tweet-right'>"                
            html += "<span class='timeago'>["+a[i].id_post+"]&nbsp;<a href='?page=profiles&userid="+a[i].userid+"'>"+a[i].username+"</a></span>"
            html += "<span>&nbsp;ha&nbsp;pubblicato&nbsp;il&nbsp;suo&nbsp;post&nbsp;numero&nbsp;"+a[i].usernumtweet+"</span>"
            html += "<span>&nbsp;-&nbsp;<?=time_since(time()-strtotime($a['datetime']))?>&nbsp;ago</span>"            
            html += "<p>"+a[i].tweet+"</p>"    
            html += "</div>"
            html += "<div class='tweet-clear'></div>"
            html += "</div>"    
     //   } /// LOOP FUNZIONA

        $("#message-posttweet").html('');
        $("#textareaId").val("").attr("placeholder", "scrivi qualcosa...");
        $('#postButton').attr("disabled", true);
        $("#colonnaPosts").prepend(html);
    }            
}
});
}); /// POST TWEET        
           

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}; /// ESTRAPOLA LE VARIABILI DALL' URL
        
var pageNum = 0;
$('#buttonLoadMess').click(function(){
    var lastId = $( ".tweet:last-of-type" ).attr('lastId'); // 10
    pageNum += 8; // cambiare in postNum
    var page = getUrlParameter('page'); 
    $.ajax({
        type: "POST",
       // cache: false,
        data: {lastId: lastId, page: page, pageNum: pageNum},  
        url: "tasks/task-loadtweet.php",
       // dataType: "json",
        beforeSend:  function() {
          $('#buttonLoadMess').html('<img src="img/loader.gif"/>');
        },
        success: function(response){  
     
            if ( response.trim() == '' ) 
            {
                $('#buttonLoadMess').html('Fine');
            }
            else
            {     console.log(response);
            var html ='';      
            var risultato = response;
            var a = JSON.parse(risultato);
            // console.log(typeof a);  console.log(a[0]['username']); console.log(a[1].username);  

            /* 
            for (var key in data) {
            if (data.hasOwnProperty(key)) { 
            console.log(data[key]["nome"]);
            html += "<div>";
            html += "<div>" + data[key]["nome"] + "</div>";
            html += "<div>" + data[key]["cognome"] + "</div>";
            html += "</div>";
            }
            } */// LOOP 1 FUNZIONA   

            /*
            $.each(data,function(index, element){ 
            console.log(element.id);        
            html += "<div>"
            html += "<div>"+element.nome+"</div>"
            html += "<div>"+element.cognome+"</div>"
            html += "</div>"
            });
*/// LOOP 2 FUNZIONA

            for(var i=0;i<a.length;i++)
            {//console.log(a[i]);
                html += "<div class='tweet' lastId='"+a[i].id_post+"'>" 
                html += "<div class='tweet-left'>img</div>"                                 
                html += "<div class='tweet-right'>"                
                html += "<span class='timeago'>["+a[i].id_post+"]&nbsp;<a href='?page=profiles&userid="+a[i].userid+"'>"+a[i].username+"</a></span>"
                html += "<span>&nbsp;ha&nbsp;pubblicato&nbsp;il&nbsp;suo&nbsp;post&nbsp;numero&nbsp;"+a[i].usernumtweet+"</span>"
                html += "<span>&nbsp;-&nbsp;<?=time_since(time()-strtotime($a['datetime']))?>&nbsp;ago</span>"            
                html += "<p>"+a[i].tweet+"</p>"    
                html += "</div>"
                html += "<div class='tweet-clear'></div>"
                html += "</div>"    
            } /// LOOP FUNZIONA

            $('#colonnaPosts').append(html);  
            $( '#colonnaPosts' ).append( $('#buttonLoadMess').show());
            $( '#buttonLoadMess').html('Carica');   
        }




            /*
                    result = result.trim();
                    var char = result.substring(0,1);
                    if ( char === 'F') 
                    {  
                        $('#buttonLoadMess').html('Fine');
                    }
                    else
                    {   
                        $( '#colonnaPosts' ).append(result);
                        $( '#colonnaPosts' ).append( $('#buttonLoadMess').show());
                        $( '#buttonLoadMess').html('Carica');
                    } *///original script vecchio
        },
       error: function (xhr, textStatus, error) {
           console.log('CE STATO UN ERRORE!!!');
           console.log(xhr);
           console.log(textStatus);
           console.log(error);
       }
    })
}); /// CARICA ALTRI TWEET
 

        
        
        
        
/**
var pageNum = 0;
$('#buttonLoadMess').click(function(){
    var lastId = $( ".tweet:last-of-type" ).attr('lastId'); 
    pageNum += 8; // cambiare in postNum
    var page = getUrlParameter('page'); 
    $.ajax({
        type: "POST",
        url: "tasks/task-loadtweet.php",
        data: {lastId: lastId, page: page, pageNum: pageNum},  
        beforeSend:  function() {
          $('#buttonLoadMess').html('<img src="img/loader.gif"/>');
        },
        success: function(result){ 
            result = result.trim();
            var char = result.substring(0,1);
            if ( char === 'F') 
            {  
                $('#buttonLoadMess').html('Fine');
            }
            else
            {   
                $( '#colonnaPosts' ).append(result);
                $( '#colonnaPosts' ).append( $('#buttonLoadMess').show());
                $( '#buttonLoadMess').html('Carica');
            } 
        },
       error: function (xhr, textStatus, error) {
           console.log(xhr);
           console.log(textStatus);
           console.log(error);
       }
    })
}); /// CARICA ALTRI TWEET
*//// CARICA ALTRI TWEET
        
        
        
$(document).on('click', '.toggleFollow', function(){
    var userid = $(this).attr('data-userId');
    var atext = $(this).children().html();  
    if ( atext === 'mio post' ) {return;}
        $.ajax({
            type: "POST",
            url: "tasks/task-follower.php",
            data: { userid: userid },
            success: function(result)
            {
                result = result.trim(); 
                $("p[data-userId='"+userid+"']").children( ".follow-link" ).html(result); 
            }
        });
    }); // SEGUI/NON SEGUIRE/MIO POST
 
/*EFFECT**********************EFFECT********************************************************************EFFECT*/
    
     
        
      
        
/* $(document).ready(function() {

    $('#pass').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false === enoughRegex.test($(this).val())) {
            $('#passstrength').html('More Characters');
        } else if (strongRegex.test($(this).val())) {
            $('#passstrength').className = 'ok';
            $('#passstrength').html('Strong!');
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength').className = 'alert';
            $('#passstrength').html('Medium!');
        } else {
            $('#passstrength').className = 'error';
            $('#passstrength').html('Weak!');
        }
        return true;
    });

}); */// PASSWORD SCRIPT
             
/*        
  $("#endfalse div").hover(function(){
    $(this).stop(true, false).animate({ width: "200px" });
}, function() {
    $(this).stop(true, false).animate({ width: "100px" });
});      *//// ALLUNGA UN DIV IN HOVER
        
        
        
    </script>
  </body>
</html>