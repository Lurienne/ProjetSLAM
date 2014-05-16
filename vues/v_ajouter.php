<div id="ajouterProduits">
	<?php 
	if (isset($erreur)) echo $erreur; // On affiche les erreurs éventuelles.
	if (isset($message)) echo $message; // On affiche les messages éventuelles.
	?> 

	<form method="POST" action="" enctype="multipart/form-data">
		<p>
			<label for="id">Identifiant : </label>
			<input type="text" name="id" id="id" required><br/>	
			<label for="image">Ajouter une image : </label>
			<input type="file" name="image" id="image"/><br/>
			<label for="description">Description : </label>
			<textarea cols="50" rows="4" name="description" id="description"></textarea><br/>
			<label for="prix">Prix : </label>
			<input type="text" name="prix" id="prix" onKeyUp="javascript:filter_numeric(this);" required><br/>

			<label for="categorie">Categories : </label>
			<select name="type">				
				<?php foreach ($listcategorie as $value) {
					if ($value['id'] == $categorie) 
						echo '<option selected value="'.$value['id'].'">'.$value['libelle'].'</option>';
					else
						echo '<option value="'.$value['id'].'">'.$value['libelle'].'</option>';					
				}?>
			</select><br />

			<input type="submit" class="hover-<?php echo $categorie ;?>" value="Ajouter"/>
		</p>
	</form>
</div>