<?php

namespace Controllers;

use League\Plates\Engine;

final readonly class ElementController {
	public function __construct(private Engine $plates) {}

	public function displayAddElement(): void {
		echo $this->plates->render('add-element');
	}
}
