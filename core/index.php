<? // JP BEHRENS 2021 - COCO CMS 
session_start();
$SID = session_id();

require(__DIR__.'/Page.php'); // PAGE CLASS
// #2: Lade die pages.json 
$page = new Page();

print "<h1>SID: $SID</h1>";

echo '<h3>URI:</h3>';
var_dump($page->uri());
echo '<hr>';

echo '<h3>Pages:</h3>';
var_dump($page->pages);

echo '<hr>';
echo '<h3>isPage:</h3>';
echo $page->isPage()? 'Super Seite': 'Error 404';

echo '<hr>';
echo '<h3>Page Data:</h3>';
var_dump($page->data());

// if($match === null){
// echo "error";
// } else {
//     echo $match['id'];
// }
