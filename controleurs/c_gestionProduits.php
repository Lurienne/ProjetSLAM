
<?php

if (!isset($_SESSION['id'])) 
{
	if (isset($_POST['connexion'])) 
	{
		$nom = htmlentities($_POST['nom']);
		$mdp = htmlentities($_POST['password']);

		$reponse = $pdo->getInfosVisiteur($nom,$mdp);

		if ($reponse) 
		{
			$_SESSION['id'] = $reponse['id'];
			header('Location:' . $_SERVER['PHP_SELF'] . '?uc=voirProduits&action=voirCategories');
		}
		else
		{
			$erreur = '<p class="erreur message">Le nom ou le mot de passe est incorrect!</p>';
		}
	}

	// else if(isset($_POST['deconnexion'])){
	// 	$message = '<p id="message">Vous êtes déconnecté.</p>';
	// 	unset($_SESSION['id']);
	// }

	include_once('vues/v_administrer.php');
}
else
{
	header('Location:' . $_SERVER['PHP_SELF'] . '?uc=voirProduits&action=voirCategories');
}

?>