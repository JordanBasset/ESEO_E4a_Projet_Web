<?php
$this->layout('template', ['title' => 'TP Mihoyo']);
?>
<h1>Collection <?= $this->e($gameName) ?></h1>

<div class="row row-cols-4" id="characters-list">
	<?php foreach ($characters as $character): ?>
		<div class="character"
			 data-character-id="<?= $character->id ?>"
			 data-character-rarity="<?= $character->rarity ?>">
			<img src="<?= $character->urlImg ?>" alt="<?= $character->name ?>"/>
			<p class="character-name fs-3"><?= $character->name ?></p>
		</div>
	<?php endforeach; ?>
</div>
