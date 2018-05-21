<?php //error_reporting(0);
 
    if (array_key_exists("page", $_GET))
    {
        include_once("connection.php");
        include_once("functions.php");
        include_once("views/header.php");
        include_once("views/navbar.php");
        include_once("views/modal-login.php"); 
        include_once("views/modal-signup.php"); 
        include_once("views/modal-lostpass.php"); 
        switch ( $_GET["page"] )
        {
            case "home"      : include_once("views/home.php");       break;  
            case "total"     : include_once("function-total.php");   include_once("views/page-total.php");    break;
            case "following" : include_once("function-follow.php");  include_once("views/page-follow.php");   break; 
            case "profiles"  : include_once("function-profile.php");include_once("views/page-profile.php");  break;
            case "search"    : include_once("views/search.php");     break;
            case "logout"    : include_once("views/home.php");       break;   
        }
    }
    else if (array_key_exists("log", $_GET))
    {
        include_once("connection.php");
        include_once("views/header.php");
        switch ( $_GET["log"] )
        {
            case "verify"  : include_once("views/verify.php");  break;  
            case "newpass" : include_once("views/newpass.php"); break;   
        }
    }
    else
    {
        include_once("connection.php");
        include_once("functions.php");
     
        include_once("views/header.php");
        include_once("views/navbar.php");
        include_once("views/modal-login.php"); 
        include_once("views/modal-signup.php"); 
        include_once("views/modal-lostpass.php"); 
        include_once("views/home.php");
    }
    include_once("views/footer.php");
?>
   <script defer src="/static/fontawesome/fontawesome-all.js"></script> <!--FONTAWESOME-->
  

