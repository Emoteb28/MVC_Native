<?php
/**
 * Created by PhpStorm.
 * User: Isaac
 * Date: 05/01/2020
 * Time: 08:54
 */

namespace App\Model;
use PDO;

include('conf/connect.php');

/**
 * Class Users
 * @package App\Model
 */
class Users
{
    public static function getAll(){
        return "connexion ok";
    }

    /** Objet contenant la connexion pdo à la BD */
    private static $connexion;

    /** Constructeur établissant la connexion */
    function __construct()
    {
        $dsn="mysql:dbname=".DATABASE.";host=".HOST;
        try{
            self::$connexion = new PDO($dsn,USER,PASSWORD);
            self::$connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $e){
            printf("Échec de la connexion : %s\n", $e->getMessage());
            $this->connexion = NULL;
        }
    }

    /** Récupére la liste des contacts sous forme d'un tableau */
    function get_all_friends()
    {
        $sql="SELECT * from carnet";
        $data=self::$connexion->query($sql);
        return $data;
    }

    /** Ajoute un contact à la table carnet */
    function add_friend($data)
    {
        $sql = "INSERT INTO carnet(NOM,PRENOM,NAISSANCE,VILLE) values (?,?,?,?)";
        $stmt = self::$connexion->prepare($sql);
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['naissance'],
            $data['ville']]
        );
    }


    /**
     * @param $id
     * @return mixed
     */
     function get_friend_by_id($id)
    {
        $sql="SELECT * from carnet where ID=:id";
        $stmt=self::$connexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /** Efface un contact à partir de son ID */
    function delete_friend_by_id($id)
    {

        $sql="Delete from carnet where ID = :id";
        $stmt=self::$connexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    /** Met jour d'une personne avec sa date de naissance et sa ville */
    function patch($id, $naissance, $ville)
    {
        $sql = "UPDATE `carnet` SET `NAISSANCE` = :naissance, `VILLE` = :ville
	 	WHERE `carnet`.`ID` = :id";
        $stmt = self::$connexion->prepare($sql);
        $stmt->bindParam(':naissance', $naissance);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /** Met à jour d'une personne avec son nom, son prénom,
     *  sa date de naissance et sa ville
     *
     */
    function update($id, $nom, $prenom, $naissance, $ville)
    {
        $sql = "UPDATE `carnet `SET `NOM` = :nom,
                SET `PRENOM` = :prenom,
                SET `NAISSANCE` = :naissance,
                SET `VILLE` = :ville
	 	        WHERE `carnet`.`ID` = :id";
        $stmt = self::$connexion->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':naissance', $naissance);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}