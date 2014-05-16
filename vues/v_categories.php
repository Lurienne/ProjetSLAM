<ul id="categories">
<?php 
foreach( $lesCategories as $uneCategorie) 
{
	$idCategorie = $uneCategorie['id'];
	$libCategorie = $uneCategorie['libelle'];

	if (!isset($_REQUEST['categorie'])) {
		$_REQUEST['categorie'] = null;
	}
	
	?>
	<li <?php if($_REQUEST['categorie'] == $idCategorie) echo "style='background-color: #9CCA46'"; ?> >
		<a <?php if($_REQUEST['categorie'] == $idCategorie) echo "style='color: #fff;'"; ?> href=index.php?uc=voirProduits&categorie=<?php echo $idCategorie ?>&action=voirProduits><?php echo $libCategorie ?></a>
	</li>
<?php
}
?>
</ul>
