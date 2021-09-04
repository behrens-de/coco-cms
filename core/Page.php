<?
class Page
{
    function __construct($prefix = '')
    {
        $this->prefix = $prefix;
        $this->pages = json_decode(file_get_contents(__DIR__ . '/../private/settings/pagelist.json', true));
        $this->domain = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'];
        $this->uri = rtrim($_SERVER['REQUEST_URI'], "/");
    }

    // #1: Check die URL 
    // TODO: Entferne den letzen Backslash des $uri Strings
    // DONE: JPBEHRENS 2021-09-03
    public function uri()
    {
        $uri = str_replace($this->prefix, "/", $this->uri);
        $uri = str_replace("//", "/", $uri);
        return $uri;
    }

    public function adminUri()
    {
        $uri = explode('admin/', $_SERVER["REQUEST_URI"]);
        return rtrim($uri[1], "/");
    }

    // #3: Finde heraus ob die URI in den Pages vertreten ist 
    public function isPage()
    {
        $isPage = false;
        foreach ($this->pages as $page) {
            if ($page->route === $this->uri()) {
                $isPage = true;
                break;
            }
        }
        return $isPage;
    }

    # 4: Erhalte die Daten der Seite 
    function data()
    {
        $data = [];
        foreach ($this->pages as $page) {
            if ($page->route === $this->uri()) {
                $data = $page;
                break;
            }
        }
        return $data;
    }

    # 4: Reload the Page
    static function reload(int $time = 1000)
    {
        return '<script>
        setTimeout(function(){window.location.reload(1);}, '.$time.');
        </script>';
    }
}
