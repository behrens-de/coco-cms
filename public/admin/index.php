<?
// COCO CMS Copyright by JP Behrens <https://jpbehrens.de> 
session_start();
$SID = session_id();
spl_autoload_register(function ($name) {
    require(__DIR__ . '/../../core/' . $name . '.php');
});


# 1. Prüfen ob es schon Anmeldedaten gibt 


/* # 2. Prüfen ob nutzer Angemeldet ist 
 * 
 * # 3. Anzeigen des richtigen Interface
 * 
 * // Interfaces
 * - 1. Regestrieren 
 * - 2. Login Formular
 * - 3. Dashboard
 * 
 * // Fragen 
 * - was passiert wen der Nutzer sein Passwort vergisst? 
 * - wie kann man seine Logindaten ändern
 */

$page = new Page();
$admin = new Admin();
$adminUri = $page->adminUri(); // the UIT after {DOMAIN}/public/admin

$settingFile = __DIR__ . '/../../private/settings/settings.json';

// Wenn firstrun noch nicht ausgeführt wurde
if (!$admin::checkFirstRun($settingFile)) {
    echo Admin::html_render(__DIR__ . '/parts/form_first_run.html', 'Daten Anlegen');

    if ($_POST) {
        $firstrun =  $admin::firstRun($settingFile, $_POST);
        if (!$firstrun) {
            print 'Ein Fehler ist aufgetreten';
        } else {
            echo '<h2>Sie werden gleich weitergeleitet</h2>';
            print Page::reload();
        }
    }
    die();
}

// Prüffen ob Eingelogt sonst zeige Anmelde formular
if (!$_SESSION['loggedin']) {

    echo Admin::html_render(__DIR__ . '/parts/form_login.html','Anmelden');
    if ($_POST) {
        $isLogIn = $admin::checkLogin($_POST) ? true : false;
        if ($isLogIn) {
            echo 'Login erfolgreich Sie werden gleich weiter geleitet';
            $_SESSION['loggedin'] = true;
            print Page::reload();

        } else {
            $_SESSION['loggedin'] = false;
            echo 'Fehler beim Anmelden';
        }
    }
    die();
}


echo 'Willkommen im Admin Bereich<hr>';
var_dump($_SESSION);



// 
// TESTED ON PHP.VERSION => 7.3.24
