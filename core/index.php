<? // JP BEHRENS 2021 - COCO CMS 
session_start();
$SID = session_id();

require(__DIR__.'/Page.php'); // PAGE CLASS
require(__DIR__.'/Menu.php'); // PAGE CLASS

$cocopage = new Page();
$cocodata = $cocopage->data();
//------------------------------------
$cocomenu = new Menu($cocopage->pages);


// TEMPLATE INFORMATION
define('TEMPLATE', ($cocodata->template ? $cocodata->template : 'default'));
define('TEMPLATE_ERROR', '404');
define('TEMPLATE_PATH', __DIR__.'/../template/');

echo '
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="La LA LA">
    <title>'.$cocodata->title.'</title>
</head>
<body>
';



// print "<h1>SID: $SID</h1>";

// echo '<h3>URI:</h3>';
// var_dump($cocopage->uri());
// echo '<hr>';

// echo '<h3>Pages:</h3>';
// var_dump($cocopage->pages);

// echo '<hr>';
// echo '<h3>isPage:</h3>';
// echo $cocopage->isPage()? 'Super Seite': 'Error 404';

// echo '<hr>';
// echo '<h3>Page cocodata:</h3>';

// print $cocodata->name;


$templateFile =  $cocopage->isPage() ? TEMPLATE : TEMPLATE_ERROR;

print $templateFile;

include(TEMPLATE_PATH.$templateFile.'.php');

// if($match === null){
// echo "error";
// } else {
//     echo $match['id'];
// }
