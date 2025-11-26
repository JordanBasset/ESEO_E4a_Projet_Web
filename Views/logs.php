<?php
$this->layout('template', ['title' => 'TP Mihoyo']);
?>

<h1>Logs</h1>

<?php
if (!empty($message)):
	$this->insert('alert', ['message' => $message['message'], 'type' => $message['type']]);
endif;
?>

<fieldset class="col-12 col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-3 form-container">
	<form action="/?action=logs" method="post" autocomplete="off">
		<label class="form-label" for="log_file">Select the log file to view:</label>
		<select class="form-select" name="log_file" id="log_file">
			<option value="" disabled selected>Select a log file</option>
			<?php foreach ($logFiles as $file): ?>
				<option value="<?= $file ?>" <?= $logFile === $file ? 'selected' : '' ?>><?= $file ?></option>
			<?php endforeach; ?>
		</select><br>
		<input type="submit" class="btn btn-outline-primary w-100" name="submit" value="See the log file">
	</form>
</fieldset>

<?php if (!empty($logFile) && !empty($logData)): ?>
	<fieldset class="form-container">
		<h2 class="text-center">Viewing log file: <?= $logFile ?></h2>

		<code>
			<?php foreach ($logData as $line): ?>
				<?= $line ?><br>
			<?php endforeach; ?>
		</code>
	</fieldset>
<?php endif; ?>
