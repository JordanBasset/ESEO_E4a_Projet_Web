<!doctype html>
<html lang="fr">
	<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="/public/css/main.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
			  integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
		<title><?= $this->e($title) ?></title>
	</head>
	<body>
		<header>
			<nav>
			</nav>
		</header>
		<main id="contenu">
			<?= $this->section('content') ?>
		</main>
		<footer>
		</footer>
	</body>
</html>
