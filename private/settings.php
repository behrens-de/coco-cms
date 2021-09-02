<?
// Load the Menu JSON 
require_once(__DIR__ . '/menu.php');
$pages = json_decode($pages, TRUE);

// Read Page Data
function pageData($arr)
{

    $data = array();
    foreach ($arr as $item) {
        if (
            (isset($_GET['page']) && isset($item['url']) && $item['url'] === $_GET['page']) ||
            (isset($_GET) && $item['url'] === "/")   

        ) {
            $data['name'] = $item['name'] !== null ? $item['name'] : false;
            $data['page'] = $item['page'] !== null ? $item['page'] : false;
            $data['header'] = $item['header'] !== null ? $item['header'] : false;
            $data['template'] = $item['template'] !== null ? $item['template'] : 'default';
            $data['title'] = $item['title'] !== null ? $item['title'] : false;
            $data['description'] = $item['description'] !== null ? $item['description'] : false;
        }
    }

    return $data;
}


// Checked if Page avaleble
function isPage($pages)
{
    foreach ($pages as $item) {

        if(
            (isset($_GET['page']) && isset($item['url']) && $item['url'] === $_GET['page']) ||
            (!isset($_GET) && $item['url'] === "/")        
        ){
            return true;
        }
    }
    return false;
}



function mainMenu($meta)
{
    $menu = '<ul>';
    foreach ($meta as $value) {

        $name = $value['name'];
        $url = $value['url'];
        $active = $_GET['page'] == $url ? 'active' : 'notActive';

        $url = strlen($url) > 0 ? 'index.php?page=' . $url : 'index.php';

        $menu .= '<li><a href="' . $url . '">' . $name . ' - ' . $active . '<a/></li>';
    }

    return $menu . '</ul>';
}







$page = pageData($pages);
$isPage = isPage($pages);
