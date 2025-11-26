<?php
$actionType = $editMode ? 'edit' : 'add';

$this->layout('template', ['title' => ucwords($actionType) . ' character']);

$characterProperty = function ($personnage, $key) {
	return $personnage !== null ? 'value="' . $this->e($personnage->$key) . '"' : '';
};
$characterSelected = static function ($personnage, $key, $id) {
	return $personnage !== null && $personnage->$key->id === $id ? 'selected' : '';
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
			<option value="" disabled <?= $editMode === false ? 'selected' : '' ?>>Choose an element</option>
			<?php foreach ($elements as $element): ?>
				<option value="<?= $element->id ?>" <?= $characterSelected(@$personnage, 'element', $element->id) ?>>
					<?= ucfirst($element->name) ?>
				</option>
			<?php endforeach; ?>
		</select><br>
		<select class="form-select" name="unit_class">
			<option value="" disabled <?= $editMode === false ? 'selected' : '' ?>>Choose a unit class</option>
			<?php foreach ($unitClasses as $unitClass): ?>
				<option value="<?= $unitClass->id ?>" <?= $characterSelected(@$personnage, 'unitClass', $unitClass->id) ?>>
					<?= ucfirst($unitClass->name) ?>
				</option>
			<?php endforeach; ?>
		</select><br>
		<input type="number" class="form-control" name="rarity" min="3" max="5" step="1" placeholder="Quality"
			<?= $characterProperty(@$personnage, 'rarity') ?>><br>
		<select class="form-select" name="origin">
			<option value="" disabled <?= $editMode === false ? 'selected' : '' ?>>Choose an origin</option>
			<?php foreach ($origins as $origin): ?>
				<option value="<?= $origin->id ?>" <?= $characterSelected(@$personnage, 'origin', $origin->id) ?>>
					<?= ucfirst($origin->name) ?>
				</option>
			<?php endforeach; ?>
		</select><br>
		<input type="url" class="form-control" name="image_url" placeholder="Image URL"
			<?= $characterProperty(@$personnage, 'urlImg') ?>><br>
		<input type="submit" class="btn btn-outline-primary w-100" name="submit"
			   value="<?= ucwords($actionType) ?> Character">
	</form>
</fieldset>
