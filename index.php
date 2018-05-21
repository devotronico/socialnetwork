<?php //error_reporting(0);
    include("connection.php");
    include("functions.php");
    include("views/header.php");
    if (array_key_exists("page", $_GET))
    {
        switch ( $_GET["page"] )
        {
            case "home"      : include("views/home.php");      break;  
            case "timeline"  : include("views/timeline.php");  break;
            case "following" : include("views/following.php"); break;
            case "profiles"  : include("views/profiles.php");  break;
            case "search"    : include("views/search.php");    break;
            case "logout"    : include("views/home.php");      break;   
        }
    }
    include("views/footer.php");
?>


 