<?php

namespace Controllers;

use League\Plates\Engine;

final readonly class MainController {
	public function __construct(private Engine $plates) {}

	public function index(): void {
		echo $this->plates->render('home', [
			'gameName' => 'Genshin Impact',
		]);
	}
}
