<?php

namespace Controllers;

use Helpers\Logger;
use League\Plates\Engine;
use Models\Origin;
use Models\OriginDAO;

final readonly class OriginController {
	public function __construct(private Engine $plates, private Logger $logger) {}

	public function addOrigin(string $name, string $imageUrl): void {
		$origin = new Origin();
		$origin->name = $name;
		$origin->urlImg = $imageUrl;

		try {
			new OriginDAO()->createOrigin($origin);

			$this->logger->log(true, 'CREATE', 'Origin', 'Created origin: ' . $name);

			$message = 'Successfully created the origin.';
			new MainController($this->plates)->index($message, 'success');
		} catch (\PDOException) {
			$this->logger->log(false, 'CREATE', 'Origin', 'Failed to create origin: ' . $name);

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
