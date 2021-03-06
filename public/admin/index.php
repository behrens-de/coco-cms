<?
// COCO CMS Copyright by JP Behrens <https://jpbehrens.de> 
session_start();
$SID = session_id();
date_default_timezone_set('Europe/Berlin');
#error_reporting(E_ERROR | E_PARSE | E_NOTICE);

spl_autoload_register(function ($name) {
    require(__DIR__ . '/../../core/' . $name . '.php');
});

define('LANG', 'de-DE');
$textLangPath = __DIR__ . '/../../private/settings/lang/' . LANG . '.json';
$txt = json_decode(file_get_contents($textLangPath, true));

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



$settingFile = __DIR__ . '/../../private/settings/admin.json';

// API
if ($adminUri === 'logincheck') {

    $txtLogin = $txt->login;

    $_POST = json_decode(file_get_contents('php://input'), true);

    $data["name"] =  $_POST['name'];
    $data["password"] =  $_POST['password'];
    $data["status"] = false;

    $logincheck = $admin::checkLogin($_POST, $settingFile) ? true : false;
    if ($logincheck) {
        $data['msg'] =  $txtLogin->msg_success;
        $data['msg2'] =  $txtLogin->msg_success2;
        $data["status"] = true;
        $_SESSION['loggedin'] = true;
        $adminData = $admin->data($settingFile);
        $_SESSION["admin"] = array('name' => $adminData->admin->name, 'id' => $adminData->admin->id, 'email' => $adminData->admin->email);
        // SET ID FROM ADMIN 
    } else {
        $data['msg'] =  $txtLogin->msg_error;
        $_SESSION['loggedin'] = false;
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    die();
}


if ($adminUri === 'logout') {
    header('Content-Type: application/json; charset=utf-8');
    $_SESSION['loggedin'] = false;
}

//-- END API

if ($adminUri === 'firstrun') {
    $txtFirstRun = $txt->first_run; // TEXTDATEI
    $_POST = json_decode(file_get_contents('php://input'), true);

    $data["name"] =  $_POST['name'];
    $data["password"] =  $_POST['password'];
    $data["check"] = $admin::firstRun($settingFile, $_POST, $admin->cocoKey());
    if ($data["check"]) {
        $data["msg"] = $txtFirstRun->msg_success;
    } else {
        $data["msg"] = $txtFirstRun->msg_error;
    }


    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    $_SESSION['loggedin'] = false;
    die();
}

if ($adminUri === 'set-new-template') {
    $_POST = json_decode(file_get_contents('php://input'), true);

    Templates::setname($_POST["name"]);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($_POST);

    die();
}


// Wenn firstrun noch nicht ausgeführt wurde
if (!$admin::checkFirstRun($settingFile)) {
    echo Admin::html_render(__DIR__ . '/parts/form_first_run.html', 'Daten Anlegen');
    die();
}

// Prüffen ob Eingelogt sonst zeige Anmelde formular
if (!$_SESSION['loggedin']) {

    echo Admin::html_render(__DIR__ . '/parts/form_login.html', 'Anmelden');
    if ($_POST) {
        $isLogIn = $admin::checkLogin($_POST, $settingFile) ? true : false;
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


$adminpage = explode('/', $page->uri);
$adminpagecount = count($adminpage) - 1;
$adminpage = $adminpage[$adminpagecount];

$adminpages = array(
    "pages" => "dashboard-pages.html",
    "menus"  => "dashboard-menus.html",
    "settings" => "dashboard-settings.html",
    "templates" => "dashboard-templates.html",
    "files" => "dashboard-data.html",
    "users" => "dashboard-user.html",
    "newsletter" => "dashboard-newsletter.html"
);

if($adminpagecount > 2){
    $adminPageLoad =  Admin::html_render(__DIR__ . '/parts/'.$adminpages[$adminpage], 'Admin Area');
    if($adminPageLoad){
        print $adminPageLoad;
    } else {
        echo 'Keinen zugrif auf diese Seite';
    }




    
} else{
    echo Admin::html_render(__DIR__ . '/parts/dashboard.html', 'Admin Area');
}
// var_dump($adminpage, $adminpagecount);

//var_dump($_SESSION["admin"]);


// The regex here is the word 'go'.


// 
// TESTED ON PHP.VERSION => 7.3.24
