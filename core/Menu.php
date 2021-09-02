<?
class Menu{
    function __construct($pages)
    {
        $this->pages = $pages;
    }

    function render($prefix)
    {
        $menu = '<ul>';
        foreach ($this->pages as $page) {
    
            $name = $page->name;
            $url = $page->route;
            $active = $_GET['page'] == $url ? 'active' : 'notActive';
    
            $url = strlen($url) > 0 ? $prefix. $url : '/';
    
            $menu .= '<li><a href="' . $url . '">' . $name . ' - ' . $active . '<a/></li>';
        }
    
        return $menu . '</ul>';
    }   


}