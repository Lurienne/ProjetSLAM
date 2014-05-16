<h2>Mon panier</h2>
<table>
<?php
foreach( $lesProduitsDuPanier as $unProduit) 
{
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$image = $unProduit['image'];
	$prix = $unProduit['prix'];
	
	?>

	<tr>
		<td><img src="<?php echo $image ?>" alt=image width=100	height=100 /></td>
		<td><?php echo	$description; ?></td>
		<td><?php echo	$prix." €"; ?></td>
		<td><a href="index.php?uc=gererPanier&produit=<?php echo $id ?>&action=supprimerUnProduit" onclick="return confirm('Voulez-vous vraiment retirer cet article frais?');">
			<img src="images/retirerpanier.png" TITLE="Retirer du panier" ></a>
		</td>
	</tr>	
	<?php
}
?>
</table>
<br>
<a class="btn" href=index.php?uc=gererPanier&action=passerCommande><img src="images/acheter.png" alt="Panier" title="panier"/> <em>Je commandes !</em></a>
