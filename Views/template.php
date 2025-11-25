<!doctype html>
<html lang="fr">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
			  integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
		<link rel="stylesheet" href="/public/css/main.css"/>
		<link rel="stylesheet" href="/public/css/whoops.css"/>
		<title><?= $this->e($title) ?></title>
	</head>
	<body>
		<header>
			<nav>
				<ul>
					<li>
						<a href="/">Home</a>
					</li>
					<li>
						<a href="/?action=add-character">Add character</a>
					</li>
					<li>
						<a href="/?action=add-element">Add element</a>
					</li>
					<li>
						<a href="/?action=add-origin">Add origin</a>
					</li>
					<li>
						<a href="/?action=search">Search</a>
					</li>
					<li>
						<a href="/?action=logs">Logs</a>
					</li>
					<li>
						<a href="/?action=login">Login</a>
					</li>
				</ul>
			</nav>
		</header>
		<main id="contenu">
			<?= $this->section('content') ?>
		</main>
		<footer>
		</footer>
	</body>
</html>
