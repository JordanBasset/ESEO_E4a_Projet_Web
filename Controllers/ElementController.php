<?php

namespace Controllers;

use Helpers\Logger;
use League\Plates\Engine;
use Models\Element;
use Models\ElementDAO;

final readonly class ElementController {
	public function __construct(private Engine $plates, private Logger $logger) {}

	public function addElement(string $name, string $imageUrl): void {
		$element = new Element();
		$element->name = $name;
		$element->urlImg = $imageUrl;

		try {
			new ElementDAO()->createElement($element);

			$this->logger->log(true, 'CREATE', 'Element', 'Created element: ' . $name);

			$message = 'Successfully created the element.';
			new MainController($this->plates)->index($message, 'success');
		} catch (\PDOException) {
			$this->logger->log(false, 'CREATE', 'Element', 'Failed to create element: ' . $name);

			$message = 'Error when trying to create the element.';
			$this->displayAddElement($message);
		}
	}

	public function displayAddElement(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-element', [
			'editMode' => false,
			'editType' => 'element',
			...$viewData,
		]);
	}
}
