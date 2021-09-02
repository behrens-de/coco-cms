<?php
session_start();
$sid = session_id();
require(__DIR__.'/../private/settings.php');
// Wenn seite nicht in _metas mit aufgeführt ist 
if (!$isPage) {
    header("HTTP/1.0 404 Not Found");
    require_once(__DIR__.'/../template/404.php');
    die();
}
?>

<? include(__DIR__.'/../template/'.$page['template'].'.php'); ?>
<body>


    <?

print $sid;
?>
<h3><? var_dump($isPage); ?></h3>
<?
print_r(http_response_code());
    // echo mainMenu($meta);

    var_dump(pageData($pages));
   // require_once('./page.php');



   var_dump(isset($_GET['page']));
    ?>


</body>

</html>