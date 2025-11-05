<?php
$this->layout('template', ['title' => 'TP Mihoyo']);
?>
<h1>Collection <?= $this->e($gameName) ?></h1>

<div class="row row-cols-4" id="characters-list">
	<?php foreach ($characters as $character): ?>
		<div class="character"
			 data-character-id="<?= $character->id ?>"
			 data-character-rarity="<?= $character->rarity ?>">
			<nav class="character-actions">
				<ul>
					<li class="character-action">
						<a href="/?action=edit-character&characterId=<?= $character->id ?>">
							<i class="bi bi-pen" aria-label="Edit character" title="Edit character"></i>
						</a>
					</li>
					<li class="character-action">
						<a href="/?action=delete-character&characterId=<?= $character->id ?>">
							<i class="bi bi-trash" aria-label="Delete character" title="Delete character"></i>
						</a>
					</li>
				</ul>
			</nav>
			<img src="<?= $character->urlImg ?>" alt="<?= $character->name ?>"/>
			<p class="character-name fs-3"><?= $character->name ?></p>
		</div>
	<?php endforeach; ?>
</div>
