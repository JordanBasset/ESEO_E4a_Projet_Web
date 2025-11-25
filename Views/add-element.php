<?php
$this->layout('template', ['title' => 'TP Mihoyo']);
?>
<h1>Add Element</h1>

<fieldset class="form-container">
	<form action="/?action=add-element" method="post" autocomplete="off">
		<input type="text" class="form-control" name="name" placeholder="Name"><br>
		<input type="url" class="form-control" name="image_url" placeholder="Image URL"><br>
		<input type="submit" class="btn btn-outline-primary w-100" name="submit" value="Add Element">
	</form>
</fieldset>
