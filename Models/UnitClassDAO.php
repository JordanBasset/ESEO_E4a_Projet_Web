<?php

namespace Models;

/**
 * DAO for manipulating {@link UnitClass unit classes} in the database.
 */
class UnitClassDAO extends BasePDODAO {
	/**
	 * Retrieves all unit classes from the database.
	 *
	 * @return UnitClass[] List of the existing unit classes
	 * @throws \PDOException If something went wrong while fetching the unit classes
	 */
	public function getAll(): array {
		$statement = $this->execRequest('SELECT * FROM unit_classes');
		$data = $statement->fetchAll(\PDO::FETCH_CLASS);
		return array_map(UnitClass::fromDBObject(...), $data);
	}

	/**
	 * Retrieves a unit class from the database using its identifier.
	 *
	 * @param string $unitClassID The identifier of the unit class to retrieve
	 * @return ?UnitClass The unit class with the given identifier, or null if not found
	 * @throws \PDOException If something went wrong while fetching the unit class
	 */
	public function getByID(string $unitClassID): ?UnitClass {
		$statement = $this->execRequest('SELECT * FROM unit_classes WHERE id = :id', ['id' => $unitClassID]);
		$data = $statement->fetchObject();
		return $data !== false ? UnitClass::fromDBObject($data) : null;
	}
}
