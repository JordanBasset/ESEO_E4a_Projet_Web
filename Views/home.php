<?php
$this->layout('template', ['title' => 'TP Mihoyo']);
?>
<h1>Collection <?= $this->e($gameName) ?></h1>

<pre>
	<?php var_dump($characters); ?>
	<?php var_dump($firstCharacter); ?>
	<?php var_dump($nullCharacter); ?>
</pre>
