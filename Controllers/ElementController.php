<?php

namespace Controllers;

use Helpers\Logger;
use League\Plates\Engine;
use Models\Element;
use Models\ElementDAO;

/**
 * Controller that handles {@link Element}-related operations.
 */
final readonly class ElementController {
	/**
	 * Creates a new instance of the controller.
	 *
	 * @param Engine $plates Templates engine instance
	 * @param Logger $logger Logger instance
	 */
	public function __construct(private Engine $plates, private Logger $logger) {}

	/**
	 * Handles retrieving the "Add Element" form data and
	 * creating the corresponding element in the database.
	 *
	 * @param string $name Element name
	 * @param string $imageUrl Element image URL
	 */
	public function addElement(string $name, string $imageUrl): void {
		$element = new Element();
		$element->name = $name;
		$element->urlImg = $imageUrl;

		try {
			new ElementDAO()->createElement($element);

			$this->logger->log(true, 'CREATE', 'Element', 'Created element: ' . $name);

			$message = 'Successfully created the element.';
			new MainController($this->plates, $this->logger)->index($message, 'success');
		} catch (\PDOException) {
			$this->logger->log(false, 'CREATE', 'Element', 'Failed to create element: ' . $name);

			$message = 'Error when trying to create the element.';
			$this->displayAddElement($message);
		}
	}

	/**
	 * Displays the "Add Element" page.
	 *
	 * @param ?string $errorMessage An optional error message to display on the page
	 */
	public function displayAddElement(?string $errorMessage = null): void {
		$viewData = $errorMessage ? ['error' => $errorMessage] : [];
		echo $this->plates->render('add-element', [
			'editMode' => false,
			'editType' => 'element',
			...$viewData,
		]);
	}
}
