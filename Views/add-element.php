<?php
$actionType = $editMode ? 'edit' : 'add';

$this->layout('template', [
	'title' => ucwords($actionType) . ' ' . str_replace('-', ' ', $editType)
]);
?>

<h1><?= ucwords($actionType) ?> <?= ucwords(str_replace('-', ' ', $editType)) ?></h1>

<?php
if (!empty($error)):
	$this->insert('alert', ['message' => $error, 'type' => 'danger']);
endif;
?>

<fieldset class="form-container">
	<form action="/?action=<?= $actionType ?>-<?= $editType ?>" method="post" autocomplete="off">
		<input type="text" class="form-control" name="name" placeholder="Name"><br>
		<input type="url" class="form-control" name="image_url" placeholder="Image URL"><br>
		<input type="submit" class="btn btn-outline-primary w-100" name="submit"
			   value="<?= ucwords($actionType) ?> <?= ucwords(str_replace('-', ' ', $editType)) ?>">
	</form>
</fieldset>
