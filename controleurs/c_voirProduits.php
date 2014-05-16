<?php
initPanier();
$action = $_REQUEST['action'];
switch($action)
{
    case 'voirCategories':
    {
        break;
    }
    case 'voirProduits' :
    {
        $categorie = $_REQUEST['categorie'];
        $lesProduits = $pdo->getLesProduitsDeCategorie($categorie);

        if (isset($_SESSION['id'])) {
             if (isset($_REQUEST['save'])) {
           $message = '<p class="message true">Les modifications on été sauvegardées</p>';
            }
            if (isset($_REQUEST['delete'])) {
               $message = '<p class="message true">Le produit à bien été supprimé.</p>';
            }
            if (isset($_REQUEST['add'])) {
               $message = '<p class="message true">Le produit à bien été ajouté.</p>';
            }          
        }

        if (isset($_REQUEST['panier'])) {
               $message = '<p class="message true">Le produit à bien été ajouté au panier.</p>';
            }
        
        include("vues/v_produits.php");
        break;
    }
    case 'ajouterAuPanier' :
    {
        $idProduit = $_REQUEST['produit'];
        $categorie = $_REQUEST['categorie'];
        
        $ok = ajouterAuPanier($idProduit);
        if(!$ok)
        {
                $message = "Cet article est déjà dans le panier !!";
                include("vues/v_message.php");
        }

        $lesProduits = $pdo->getLesProduitsDeCategorie($categorie);
        header('Location:' . $_SERVER['PHP_SELF'] . '?uc=voirProduits&categorie='.$categorie.'&action=voirProduits&panier');
        break;
    }

    case 'modifierProduit':
        $idProduit = array();
        $idProduit[] = $_REQUEST['produit'];
        $categorie = $_REQUEST['categorie'];

        $produit = $pdo->getLesProduitsDuTableau($idProduit);
        $categories = $pdo->getLesCategories();

        if (isset($_SESSION['id'])) // On vérifie si une session est bien ouverte.
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST') // Si le formulaire a été soumis...
            {
                $destination = NULL;
                $idCategorie =  htmlspecialchars($_POST['type']);
                if (!empty($_FILES['image']['name'])) // Si une image a été uplodée, on gère les différentes erreur.
                { 
                    if ($_FILES['image']['size'] > 10000000) // Si le fichier est trop gros..
                        $erreur = '<p class="erreur message">Le fichier est trop gros.</p>';
                    else { // Si le fichier n'est pas trop gros, on verifie si l'extension est correcte.            
                        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
                        $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
                        if (in_array($extension_upload,$extensions_valides)) // Si tout est bon on enregistre le fichier
                        {
                            $name = $idProduit[0] . '.' . $extension_upload;
                            $destination = getDestination($categorie, $name);
                            move_uploaded_file($_FILES['image']['tmp_name'], $destination);              
                        }                         
                        else // Sinon on affiche une erreur.
                            $erreur = '<p class="erreur message">Le fichier n\'est pas valide.</p>';
                    }
                } 
    
                $description = htmlspecialchars($_POST['description']); 
                $prix = htmlspecialchars($_POST['prix']);  
                
                //On deplace l'image si la catégorie change
                if ($idCategorie != $categorie) {                    
                    if ($destination == NULL) // Si aucune nouvelle image, on va chercher celle en bdd.
                        $destination = explode('/', $produit[0]['image']);

                    else // Sinon on récupère l'image donnée dans le formulaire
                        $destination = explode('/', $destination);
                        $destination = getDestination($idCategorie, $destination[2]);
                    
                    rename($produit[0]['image'],$destination); // Et on la déplace dans le serveur.
                }
               
               if (!isset($erreur)) { // Si aucune erreur on enregristre en bdd.
                    $pdo->setProduit($description, $prix, $destination, $idProduit[0], $idCategorie); // On enregistre en base de donnée.
                    header('Location:' . $_SERVER['PHP_SELF'] . '?uc=voirProduits&categorie='.$idCategorie.'&action=voirProduits&save');           
               }             
            } 
        }
        else
        {
            header('Location: ' . $_SERVER['PHP_SELF'] . '?uc=404');
        }

        include("vues/v_editer.php");
        break;

    case 'supprimerProduit' :
        $idProduit = $_REQUEST['produit'];
        $categorie = $_REQUEST['categorie'];

        if (isset($_SESSION['id'])) 
        {
            $pdo->deleteProduit($idProduit);    
           header('Location:' . $_SERVER['PHP_SELF'] . '?uc=voirProduits&categorie='.$categorie.'&action=voirProduits&delete');
        }
        else
        {
            header('Location: ' . $_SERVER['PHP_SELF'] . '?uc=404');
        }       
        break;

    case 'ajouterProduit' :
        $categorie = $_REQUEST['categorie'];
        $listcategorie = $pdo->getLesCategories();

        if (isset($_SESSION['id'])) // On vérifie si une session est bien ouverte.
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST') // Si le formulaire a été soumis...
            {
                $description = null;               
                $id = htmlspecialchars($_POST['id']);
                $arrayId = array();
                $arrayId[] = $id;
                $idCategorie =  htmlspecialchars($_POST['type']);
 
                if($pdo->getLesProduitsDuTableau($arrayId)[0])
                    $erreur = '<p class="erreur message">Cette identidant existe déjà !</p>';   

                if (!empty($_FILES['image']['name'])) // Si une image a été uplodée, on gère les différentes erreur.
                { 
                    if ($_FILES['image']['size'] > 1000000) // Si le fichier est trop gros..
                        $erreur = '<p class="erreur" class="message">Le fichier est trop gros.</p>';
                    else { // Si le fichier n'est pas trop gros, on verifie si l'extension est correcte.               
                        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
                        $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );

                        if (in_array($extension_upload,$extensions_valides)) // Si tout est bon on enregistre le fichier
                        {
                            $name = $id . '.' . $extension_upload;
                            $destination = getDestination($idCategorie, $name); // On construit l'url grâce à une fonction prévu pour cette effet

                            $img = move_uploaded_file($_FILES['image']['tmp_name'], $destination);   // On enregistre l'image sur le serveur.                
                        }                         
                        else // Sinon on affiche une erreur.
                            $erreur = '<p class="erreur message">Le fichier n\'est pas valide.</p>';
                    }
                }
                else
                    $destination = getDestination($idCategorie, 'empty.png');
    
                $description = htmlspecialchars($_POST['description']); 
                $prix = htmlspecialchars($_POST['prix']);  

               if (!isset($erreur)) {
                    $pdo->ajouterProduit($id, $description, $prix, $destination, $idCategorie); // On enregistre en base de donnée.
                    header('Location:' . $_SERVER['PHP_SELF'] . '?uc=voirProduits&categorie='.$idCategorie.'&action=voirProduits&add');           
               }                       
            } 
        }
        else
        {
            header('Location: ' . $_SERVER['PHP_SELF'] . '?uc=404');
        }

        include("vues/v_ajouter.php");
        break;

    default :
        header('Location: ' . $_SERVER['PHP_SELF'] . '?uc=404');
        break;
}