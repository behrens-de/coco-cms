<?
class Menu{
    function __construct($pages, $uri)
    {
        $this->pages = $pages;
        $this->uri = $uri;
    }

    function render($prefix, $class = null)
    {
        $class = $class !== null ? ' class="'.$class.'"': '';
        $menu = '<nav'.$class.'><ul>';
        foreach ($this->pages as $page) {

            $uri_without_prefix = str_replace($prefix,'',$this->uri);
    
            $name = $page->name;
            $url = $page->route;
            $active = $uri_without_prefix == $url ? 'active' : '';
            $url = strlen($url) > 0 ? $prefix. $url : '/';
    
            $menu .= '<li class="' . $active . '"><a href="' . $url . '">' . $name . '</a></li>';
        }
    
        return $menu . '</ul></nav>';
    }   


}