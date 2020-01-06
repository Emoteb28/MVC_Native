<?php
/**
 * Created by PhpStorm.
 * User: Isaac
 * Date: 05/01/2020
 * Time: 08:17
 */

require_once 'vendor/autoload.php';
use \App\Controller\userController;
use App\Model\Users;
session_start();
$go = new Users();
$control = new userController();
$controller = new userController();

//echo $controller->index();
//echo "$_SERVER[HTTP_COOKIE]";



// le dossier ou on trouve les templates
$loader = new Twig_Loader_Filesystem('App/templates');

// initialiser l'environement Twig
$twig = new Twig_Environment($loader);



//Router
$action = $_GET['action'] ?? 'list';
$message = "";

switch ($action) {
    case "list":
        $control->list_action( $twig, $message);
        break;
    case "detail":
        $control->detail_action( $twig, $message);
        break;
    default:
        $control->list_action($twig, $message);
    case "suppr":
        if ($control->suppr_action( $_GET['id']))
            $message = "Personne supprimée avec succès !";
        else $message = "Pb de suppression !";

        header('Status: 301 Moved Permanently', false, 301);
        header('Location: index.php');

        //($control->list_action($twig,$message);
        break;
}

