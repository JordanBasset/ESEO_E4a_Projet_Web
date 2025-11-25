<?php

namespace Controllers;

use League\Plates\Engine;

final readonly class ElementController {
	public function __construct(private Engine $plates) {}

	public function displayAddElement(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-element', [
			'editMode' => false,
			'editType' => 'element',
			...$viewData,
		]);
	}
}
