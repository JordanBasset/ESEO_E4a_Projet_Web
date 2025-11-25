<?php

namespace Controllers;

use League\Plates\Engine;
use Models\Origin;
use Models\OriginDAO;

final readonly class OriginController {
	public function __construct(private Engine $plates) {}

	public function addOrigin(string $name, string $imageUrl): void {
		$origin = new Origin();
		$origin->name = $name;
		$origin->urlImg = $imageUrl;

		try {
			new OriginDAO()->createOrigin($origin);
			$message = 'Successfully created the origin.';
			new MainController($this->plates)->index($message, 'success');
		} catch (\PDOException) {
			$message = 'Error when trying to create the origin.';
			$this->displayAddOrigin($message);
		}
	}

	public function displayAddOrigin(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-element', [
			'editMode' => false,
			'editType' => 'origin',
			...$viewData,
		]);
	}
}
