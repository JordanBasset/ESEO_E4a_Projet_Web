<?php

namespace Controllers;

use League\Plates\Engine;

final readonly class PersonnageController {
	public function __construct(private Engine $plates) {}

	public function displayAddElement(): void {
		echo $this->plates->render('add-element');
	}

	public function displayAddPersonnage(): void {
		echo $this->plates->render('add-perso');
	}
}
