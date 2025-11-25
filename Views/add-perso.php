<?php
$this->layout('template', ['title' => 'TP Mihoyo']);

$actionType = $editMode ? 'edit' : 'add';
$characterProperty = function ($personnage, $key) {
	return $personnage !== null ? 'value="' . $this->e($personnage->$key) . '"' : '';
};
$characterSelected = static function ($personnage, $key, $value) {
	return $personnage !== null && $personnage->$key === $value ? 'selected' : '';
};
?>

<h1><?= ucwords($actionType) ?> Character</h1>

<?php
if (!empty($error)):
	$this->insert('alert', ['message' => $error, 'type' => 'danger']);
endif;
?>

<fieldset class="form-container">
	<form action="/?action=<?= $actionType ?>-character" method="post" autocomplete="off">
		<?php if ($editMode): ?>
			<input type="hidden" name="id" value="<?= $personnage->id ?>">
		<?php endif; ?>
		<input type="text" class="form-control" name="name" placeholder="Name"
			<?= $characterProperty(@$personnage, 'name') ?>><br>
		<select class="form-select" name="element">
			<option value="" disabled <?= $editMode === false ? 'selected' : '' ?>>Element</option>
			<option value="hydro" <?= $characterSelected(@$personnage, 'element', 'Hydro') ?>>Hydro</option>
			<option value="electro" <?= $characterSelected(@$personnage, 'element', 'Electro') ?>>Electro</option>
			<option value="cryo" <?= $characterSelected(@$personnage, 'element', 'Cryo') ?>>Cryo</option>
		</select><br>
		<input type="text" class="form-control" name="unit_class" placeholder="Weapon"
			<?= $characterProperty(@$personnage, 'unitClass') ?>><br>
		<input type="number" class="form-control" name="rarity" min="3" max="5" step="1" placeholder="Quality"
			<?= $characterProperty(@$personnage, 'rarity') ?>><br>
		<input type="text" class="form-control" name="origin" placeholder="Region"
			<?= $characterProperty(@$personnage, 'origin') ?>><br>
		<input type="url" class="form-control" name="image_url" placeholder="Image URL"
			<?= $characterProperty(@$personnage, 'urlImg') ?>><br>
		<input type="submit" class="btn btn-outline-primary w-100" name="submit"
			   value="<?= ucwords($actionType) ?> Character">
	</form>
</fieldset>
