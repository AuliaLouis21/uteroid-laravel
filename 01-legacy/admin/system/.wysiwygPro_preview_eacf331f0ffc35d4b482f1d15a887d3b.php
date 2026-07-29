<?php
if ($_GET['randomId'] != "iG3eNx1UcdKYCjXDifa7vBb1xMJrf9WFOxhjs1uYDqTRcgqtrf7sRgRw0tkQXO1a") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
