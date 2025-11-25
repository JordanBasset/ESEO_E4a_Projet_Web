<?php

namespace Models;

/**
 * DAO for manipulating {@link Element elements} in the database.
 */
class ElementDAO extends BasePDODAO {
	/**
	 * Retrieves all elements from the database.
	 *
	 * @return Element[] List of the existing elements
	 * @throws \PDOException If something went wrong while fetching the elements
	 */
	public function getAll(): array {
		$statement = $this->execRequest('SELECT * FROM elements');
		$data = $statement->fetchAll(\PDO::FETCH_CLASS);
		return array_map(Element::fromDBObject(...), $data);
	}

	/**
	 * Retrieves an element from the database using its identifier.
	 *
	 * @param string $elementID The identifier of the element to retrieve
	 * @return ?Element The element with the given identifier, or null if not found
	 * @throws \PDOException If something went wrong while fetching the element
	 */
	public function getByID(string $elementID): ?Element {
		$statement = $this->execRequest('SELECT * FROM elements WHERE id = :id', ['id' => $elementID]);
		$data = $statement->fetchObject();
		return $data !== false ? Element::fromDBObject($data) : null;
	}
}
