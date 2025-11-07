<?php
$this->layout('template', ['title' => 'TP Mihoyo']);
?>
<h1>Add Character</h1>

<?php
if (!empty($error)):
	$this->insert('alert', ['message' => $error, 'type' => 'danger']);
endif;
?>

<fieldset class="form-container">
	<form action="/?action=add-character" method="post" autocomplete="off">
		<input type="text" class="form-control" name="name" placeholder="Name"><br>
		<select class="form-select" name="element">
			<option value="" disabled selected>Element</option>
			<option value="hydro">Hydro</option>
			<option value="electro">Electro</option>
			<option value="cryo">Cryo</option>
		</select><br>
		<input type="text" class="form-control" name="unit_class" placeholder="Weapon"><br>
		<input type="number" class="form-control" name="rarity" min="3" max="5" step="1" placeholder="Quality"><br>
		<input type="text" class="form-control" name="origin" placeholder="Region"><br>
		<input type="url" class="form-control" name="image_url" placeholder="Image URL"><br>
		<input type="submit" class="btn btn-outline-primary w-100" name="submit" value="Add Character">
	</form>
</fieldset>
