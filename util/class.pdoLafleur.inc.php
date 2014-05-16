<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application lafleur
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoLafleur qui contiendra l'unique instance de la classe
 *
 * @package default
 * @author Patrice Grand
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoLafleur
{   		
    private static $serveur='mysql:host=localhost';
    private static $bdd='dbname=lafleur';   		
    private static $user='root' ;    		
    private static $mdp='' ;	
    
    private static $monPdo;
    private static $monPdoLafleur = null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
    private function __construct()
    {
        PdoLafleur::$monPdo = new PDO(PdoLafleur::$serveur.';'.PdoLafleur::$bdd, PdoLafleur::$user, PdoLafleur::$mdp); 
        PdoLafleur::$monPdo->query("SET CHARACTER SET utf8");
    }
    public function _destruct(){
        PdoLafleur::$monPdo = null;
    }
/**
 * Fonction statique qui crée l'unique instance de la classe
 *
 * Appel : $instancePdolafleur = PdoLafleur::getPdoLafleur();
 * @return l'unique objet de la classe PdoLafleur
 */
    public  static function getPdoLafleur()
    {
        if(PdoLafleur::$monPdoLafleur == null)
        {
            PdoLafleur::$monPdoLafleur= new PdoLafleur();
        }
        return PdoLafleur::$monPdoLafleur;  
    }
/**
 * Retourne toutes les catégories sous forme d'un tableau associatif
 *
 * @return le tableau associatif des catégories 
*/
    public function getLesCategories()
    {
        $req = "select * from categorie";
        $res = PdoLafleur::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

/**
 * Retourne sous forme d'un tableau associatif tous les produits de la
 * catégorie passée en argument
 * 
 * @param $idCategorie 
 * @return un tableau associatif  
*/

    public function getLesProduitsDeCategorie($idCategorie)
    {
        $req="select * from produit where idCategorie = '$idCategorie'";
            $res = PdoLafleur::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes; 
    }
/**
 * Retourne les produits concernés par le tableau des idProduits passée en argument
 *
 * @param $desIdProduit tableau d'idProduits
 * @return un tableau associatif 
*/
    public function getLesProduitsDuTableau($desIdProduit)
    {      
        foreach($desIdProduit as $unIdProduit)
        {
            $req = "select * from produit where id = '$unIdProduit'";
            $res = PdoLafleur::$monPdo->query($req);
            $unProduit = $res->fetch();
            $lesProduits[] = $unProduit;
        }
        return $lesProduits;
    }
/**
 * Crée une commande 
 *
 * Crée une commande à partir des arguments validés passés en paramètre, l'identifiant est
 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
 * tableau d'idProduit passé en paramètre
 * @param $nom 
 * @param $rue
 * @param $cp
 * @param $ville
 * @param $mail
 * @param $lesIdProduit
 
*/
    public function creerCommande($nom,$rue,$cp,$ville,$mail, $lesIdProduit )
    {
        $req = "select max(id) as maxi from commande";
        echo $req."<br>";
        $res = PdoLafleur::$monPdo->query($req);
        $laLigne = $res->fetch();
        $maxi = $laLigne['maxi'] ;
        $maxi++;
        $idCommande = $maxi;
        echo $idCommande."<br>";
        echo $maxi."<br>";
        $date = date('Y/m/d');
        $req = "insert into commande values ('$idCommande','$date','$nom','$rue','$cp','$ville','$mail')";
        echo $req."<br>";
        $res = PdoLafleur::$monPdo->exec($req);
        foreach($lesIdProduit as $unIdProduit)
        {
            $req = "insert into contenir values ('$idCommande','$unIdProduit')";
            echo $req."<br>";
            $res = PdoLafleur::$monPdo->exec($req);
        }
    }

    public function getInfosVisiteur($login, $mdp){
        $req = "select * from administrateur
        where administrateur.nom='$login' and administrateur.mdp='$mdp'";
        $rs = PdoLafleur::$monPdo->query($req);
        $ligne = $rs->fetch();
        return $ligne;
    }

    public function setVisiteur($id)
    {
        $req = "select * from administrateur
        where administrateur.id='$id'";
        $rs = PdoLafleur::$monPdo->query($req);
        $ligne = $rs->fetch();
        return $ligne;
    }

    public function setProduit($description, $prix, $img, $idProduit, $idCategorie)
    {
        $prix = (double) $prix; // On convertie en décimal pour être sûr de n'avoir que des chiffres en bdd.
        $req = "update produit set description = '". $description . "', prix = '". $prix ."',image = '". $img ."', idCategorie = '". $idCategorie ."' WHERE id = '" . $idProduit . "'";
        $res = PdoLafleur::$monPdo->query($req);
    }

    public function deleteProduit($idProduit)
    {
        $req = "delete from produit where id ='" . $idProduit . "'";       
        $res = PdoLafleur::$monPdo->query($req);    
    }

    public function ajouterProduit($id, $description, $prix, $img, $categorie)
    {
        $prix = (double) $prix; 
        $req = "insert into produit values ('$id','$description','$prix','$img','$categorie')";
        $res = PdoLafleur::$monPdo->query($req);
    }
}
?>