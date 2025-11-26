<?php
$this->layout('template', ['title' => 'Login']);
?>

<h1>Login</h1>

<?php
if (!empty($error)):
	$this->insert('alert', ['message' => $error, 'type' => 'danger']);
endif;
?>

<fieldset class="form-container">
	<form action="/?action=login" method="post" autocomplete="off">
		<input type="text" class="form-control" name="username" placeholder="Username"><br>
		<input type="password" class="form-control" name="password" placeholder="Password"><br>
		<input type="submit" class="btn btn-outline-primary w-100" name="submit" value="Login">
	</form>
</fieldset>
