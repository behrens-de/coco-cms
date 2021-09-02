<?
class Menu{
    function __construct($pages, $uri)
    {
        $this->pages = $pages;
        $this->uri = $uri;
    }

    function render($prefix)
    {
        $menu = '<ul>';
        foreach ($this->pages as $page) {

            $uri_without_prefix = str_replace($prefix,'',$this->uri);
    
            $name = $page->name;
            $url = $page->route;
            $active = $uri_without_prefix == $url ? 'active' : '';
            $url = strlen($url) > 0 ? $prefix. $url : '/';
    
            $menu .= '<li class="' . $active . '"><a href="' . $url . '">' . $name . '</a></li>';
        }
    
        return $menu . '</ul>';
    }   


}