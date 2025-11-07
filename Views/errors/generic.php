<?php
$this->layout('template', ['title' => 'TP Mihoyo']);
?>
<div data-whoops>
	<h1>Whoops...</h1>

	<i class="bi bi-exclamation-triangle" data-whoops-icon></i>

	<p data-whoops-message><?= $details ?></p>

	<details data-whoops-trace>
		<summary>Click here for details</summary>
		<?= nl2br($trace) ?>
	</details>

	<div data-whoops-call-to-action>
		<a class="btn btn-outline-primary" href="javascript:history.back()">Back to previous page</a><br>
		<a class="btn btn-outline-primary" href="/">Back to home page</a>
	</div>
</div>
