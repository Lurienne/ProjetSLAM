<div id="produits">
<?php
if (isset($message)) echo $message; // On affiche les messages éventuelles.

if (isset($_SESSION['id'])) echo '<a class="btn" href=index.php?uc=voirProduits&categorie='.$categorie.'&action=ajouterProduit><img src="images/ajouter.png"> <em>Nouveau produit</em></a>';
?>

<table>	
<?php
foreach( $lesProduits as $unProduit) 
{
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$prix=$unProduit['prix'];
	$image = $unProduit['image'];
	?>	
	<tr>
		<td style="width: 10%;"><img class="imgProduit" src="<?php echo $image ?>" alt=image /></td>
		<td><?php echo $description ?></td>
		<td><?php echo $prix; ?> €</td>
		<td>
			<a href=index.php?uc=voirProduits&categorie=<?php echo $categorie ?>&produit=<?php echo $id ?>&action=ajouterAuPanier> 
			 	<img src="images/mettrepanier.png" TITLE="Ajouter au panier">
			</a>
		</td>
		<?php if (isset($_SESSION['id'])) {?>
			<td><a href=index.php?uc=voirProduits&categorie=<?php echo $categorie ?>&produit=<?php echo $id ?>&action=modifierProduit> 
			<img src="images/modifierarticle.png" TITLE="Modifier l'article"></a></td>
			<td><a href=index.php?uc=voirProduits&categorie=<?php echo $categorie ?>&produit=<?php echo $id ?>&action=supprimerProduit onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce produit?'));"> 
			<img src="images/supprimerarticle.png" TITLE="Supprimer l'article"></a></td>
		<?php } ?>	
	</tr>				
<?php } ?>
</table>
</div>