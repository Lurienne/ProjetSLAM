<?php 
	if (isset($erreur)) echo $erreur; // On affiche les erreurs éventuelles.
	if (isset($message)) echo $message; // On affiche les messages éventuelles.
?>

<div id="administrer">
	<form method="POST" action="">
		<label for="nom">Nom</label><input type="text" name="nom" id="nom"required/><br />
		<label for="password">Mot de passe</label><input type="password" name="password" id="password" required/><br />
		<input type="submit" value="Connexion" name="connexion"/>		
	</form>
</div>