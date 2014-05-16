<header>
	<div id="bandeau">
	<!-- Images En-tête -->
	<!--<img src="images/menuGauche.gif"	alt="Choisir" title="Choisir"/>-->
	<img src="images/lafleur.gif"	alt="Lafleur" title="Lafleur"/>
	</div>

	<?php
		if (!isset($_REQUEST['uc'])) {
			$_REQUEST['uc'] = null;
		}
	?>

	<!--  Menu haut-->
	<nav>
		<ul class="top-menu"><!-- attention à bien faire correspondre l'id de chaque item avec la feuilles de style -->
			<li><a href="index.php?uc=accueil" <?php if ($_REQUEST['uc'] == 'accueil') { echo "style='top:47px;'";}?>>Accueil</a><div class="menu-item" id="item1" <?php if ($_REQUEST['uc'] == 'accueil') { echo "style='border-top-left-radius: 96px;height: 110px;'";}?>></div></li>
			<li><a href="index.php?uc=voirProduits&action=voirCategories" <?php if ($_REQUEST['uc'] == 'voirProduits') { echo "style='top:46px;'";}?>>Catalogue</a><div class="menu-item" id="item2" <?php if ($_REQUEST['uc'] == 'voirProduits') { echo "style='border-top-left-radius: 96px;height: 110px;'";}?>></div></li>
			<li><a href="index.php?uc=gererPanier&action=voirPanier" <?php if ($_REQUEST['uc'] == 'gererPanier') { echo "style='top:46px;'";}?>>Mon panier</a><div class="menu-item" id="item3" <?php if ($_REQUEST['uc'] == 'gererPanier') { echo "style='border-top-left-radius: 96px;height: 110px;'";}?>></div></li>
			<li><a href="index.php?uc=administrer" <?php if ($_REQUEST['uc'] == 'administrer') { echo "style='top:46px;'";}?>>Administrer</a><div class="menu-item" id="item4" <?php if ($_REQUEST['uc'] == 'administrer') { echo "style='border-top-left-radius:96px;height:110px;'";}?>></div></li>
		</ul>
	</nav>

	<!--  Le bloc du profil  -->
	<?php if (isset($_SESSION['id'])) { ?>
		<div class="bloc-user">
			<p>Bonjour <?php echo $visiteur['nom']; ?> !</p>
			<form method="POST" action="">
				<input type="submit" value="deconnexion" name="deconnexion"/>
			</form>
		</div>
	<?php } ?>	

	<div class="bloc-new">
		<p>Lafleur, le prince des fleurs sur internet</p>
	<div>
</header>
