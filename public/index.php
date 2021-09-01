<?php
session_start();
$sid = session_id();
require(__DIR__.'/../private/settings.php');
// Wenn seite nicht in _metas mit aufgeführt ist 
// if (!isPage($meta)) {
//     header("HTTP/1.0 404 Not Found");
//     require_once('../pages/404.php');
//     die();
// }
?>

<? include(__DIR__.'/../template/'.$page['template'].'.php'); ?>
<body>


    <?php

print $sid;

print_r(http_response_code());
    // echo mainMenu($meta);

    var_dump(pageData($pages));
   // require_once('./page.php');
    ?>


</body>

</html>