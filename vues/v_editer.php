<div id="editerProduits">
	<?php 
	if (isset($erreur)) echo $erreur; // On affiche les erreurs éventuelles.
	if (isset($message)) echo $message; // On affiche les messages éventuelles.
	?>

	<h2>Modifier le produit</h2>

	<form method="POST" action="" enctype="multipart/form-data">
		<img class="imgProduit" src="<?php echo $produit[0]['image']; ?>" /><br />	
			<label for="image">Modifier l'image : </label>
			<input type="file" name="image" id="image"/><br />	
			<label for="description">Description : </label>
			<textarea cols="50" rows="4" name="description" id="description"><?php echo $produit[0]['description']; ?></textarea><br />	
			<label for="prix">Prix : </label>
			<input type="text" name="prix" id="prix" onKeyUp="javascript:filter_numeric(this);" required value="<?php echo $produit[0]['prix']; ?> €"><br />	
			
			<label for="categorie">Categories : </label>
			<select name="type">				
				<?php foreach ($categories as $value) {
					if ($value['id'] == $categorie) 
						echo '<option selected value="'.$value['id'].'">'.$value['libelle'].'</option>';
					else
						echo '<option value="'.$value['id'].'">'.$value['libelle'].'</option>';					
				}?>
			</select><br />

			<input type="submit" value="Modifier"/>

	</form>
</div>