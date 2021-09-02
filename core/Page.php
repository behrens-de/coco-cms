<?
class Page
{

    function __construct()
    {
        $this->pages = json_decode(file_get_contents(__DIR__.'/../private/settings/pagelist.json', true)); 
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    // #1: Check die URL 
    // TODO: Entferne den letzen Backslash des $uri Strings
    public function uri()
    {
        $uri = str_replace("/core", "/", $this->uri);
        $uri = str_replace("//", "/", $uri);
        return $uri;
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
                $data["hallo"] = "Hallo";
                break;
            }
        }
        return $data;
    }
}
