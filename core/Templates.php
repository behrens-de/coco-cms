<?
class Templates
{

    static function name()
    {
        $path = __DIR__ . '/../private/settings/template.json';
        $json = json_decode(file_get_contents($path, true));
        return $json->name;
    }


    static function setname($newName)
    {
        $path = __DIR__ . '/../private/settings/template.json';
        // $data = json_decode(file_get_contents($path, true));
        $data["name"] = $newName;

        $file = fopen($path, 'w');
        fwrite($file, json_encode($data));
        fclose($file);
        return true;
    }

    static function pages($templatename = null)
    {
        if ($templatename === null) {
            $templatename = Templates::name();
        }

        $path = __DIR__ . '/../template/' . $templatename . '/';
        $output = '';
        $templateCount = 0;
        $templateNames = array();
        // Test, ob es sich um ein Verzeichnis handelt
        if (is_dir($path)) {
            // öffnen des Verzeichnisses
            if ($handle = opendir($path)) {
                // einlesen der Verzeichnisses

                while (($file = readdir($handle)) !== false) {

                    // if (strpos($file, ".") !== false) {
                    //     //$output .= 'Dateiname: ' . filetype($file) . '<hr>';
                    // } else {
                        $templateNames[$templateCount] = '<span class="tpl-prev-active">' . $file . '' .is_dir($path.$file) . '</span>';
                        $templateCount++;
                    // }
                }
                closedir($handle);
            }
        }
        return '<h2>' . $templatename . '</h2>' . implode('', $templateNames);
   
   
        function readAllDir($templatename){
            $root = __DIR__ . '/../template/';
            $path = $root.$templatename . '/';
        }
   
    }


    static function list()
    {

        $path = __DIR__ . '/../template/';
        $output = '';
        $templateCount = 0;
        $templateNames = array();
        // Test, ob es sich um ein Verzeichnis handelt
        if (is_dir($path)) {
            // öffnen des Verzeichnisses
            if ($handle = opendir($path)) {
                // einlesen der Verzeichnisses

                while (($file = readdir($handle)) !== false) {

                    if (strpos($file, ".") !== false) {
                        //$output .= 'Dateiname: ' . filetype($file) . '<hr>';
                    } else {
                        if ($file === Templates::name()) {
                            $templateNames[$templateCount] = '<span class="tpl-prev-active">' . $file . '</span>';
                        } else {
                            $templateNames[$templateCount] = '<span class="tpl-prev">' . $file . '</span>';
                        }

                        $templateCount++;
                    }
                }
                closedir($handle);
            }
        }
        return '<h2>Verfügbare Templates</h2>' . implode('', $templateNames);
    }
}
