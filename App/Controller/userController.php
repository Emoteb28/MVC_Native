<?php
/**
 * Created by PhpStorm.
 * User: Isaac
 * Date: 05/01/2020
 * Time: 08:34
 */

namespace App\Controller;
use App\Model\Users;


class userController
{
    private  $connexion;

    /**
     * userController constructor.
     */
    public function __construct()
    {

        $this->connexion = new Users();
    }

    public function index()
    {
        // TODO: Implement __call() method.
        $Users = Users::getAll();
        /*$Users = new Users();
        $ok = $Users->getAll();*/
        return $Users;
    }

     /*public function connexion()
        {
            $Users = new Users();
            //$cont = $Users->getAll();
            return $Users;
        }
     */


    public function list_action($twig, $message){

        $amis = $this->connexion->get_all_friends();
        $template = $twig->loadTemplate('carnet.twig.html');
        $titre="Mes Contacts";
        echo $template->render(array(
            'titre' => $titre,
            'amis' => $amis,
            'message' => $message
        ));
    }

    public function detail_action($twig, $id,$message=''){
        $ami = $this->connexion->get_friend_by_id($id);
        $template = $twig->loadTemplate('detail.twig.html');
        $id = $_GET['id'];
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $titre="Détails";
        echo $template->render(array(
            'titre' => $titre,
            'ami' => $ami,
            'nom' => $nom,
            'prenom' => $prenom,
            "id" => $id,
            'message' => $message
        ));
    }

    function suppr_action($id){
        return ($this->connexion->delete_friend_by_id($id));
    }

    function patch_action($cont, $id, $naissance, $ville){
        return ($this->connexion->patch($id,$naissance,$ville ));
    }

    function add_action($cont, $contact){
        return ($this->connexion->add_friend($contact));
    }

}