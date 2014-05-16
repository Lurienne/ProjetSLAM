<?php
	session_start();
	require_once("util/fonctions.inc.php");
	require_once("util/class.pdoLafleur.inc.php");

	$pdo = PdoLafleur::getPdoLafleur();	

	// On gère la connexion
	if (isset($_POST['deconnexion'])) 
	{
		unset($_SESSION['id']);
		header('Location:' . $_SERVER['PHP_SELF'] . '?uc=accueil');
	}	

	if (isset($_SESSION['id'])) // On récupère les infos du visiteur connecté.
	{
		$id = htmlspecialchars($_SESSION['id']);
		$visiteur = $pdo->setVisiteur($id);
	}
?>

<div id="content">
	<?php
		include("vues/v_entete.php") ;
		include("vues/v_bandeau.php") ;
		if(!isset($_REQUEST['uc']))
			     $uc = 'accueil';
			else
				$uc = $_REQUEST['uc'];
	?>
	<section>
		<?php 
			if($uc == 'voirProduits') 
			{ 
				echo '<aside>';
					$lesCategories = $pdo->getLesCategories();
		        	include("vues/v_categories.php");
				echo '</aside>';
			} 
		?>

		<?php			
			switch($uc)
			{
				case 'accueil':
					{include("vues/v_accueil.php");break;}
				case 'voirProduits' :
					{include("controleurs/c_voirProduits.php");break;}
				case 'gererPanier' :
					{ include("controleurs/c_gestionPanier.php");break; }
				case 'administrer' :
				  { include("controleurs/c_gestionProduits.php");break;  }
				case '404' :
					{include("vues/v_404.php");break;}
				default :
					{include("vues/v_404.php");break;}
					break;
			}
		?>
	</section>
		
	<?php include("vues/v_pied.php"); ?>	
</div>

