<?php

namespace Models;

/**
 * DAO for manipulating {@link Personnage characters} in the database.
 */
class PersonnageDAO extends BasePDODAO {
	/**
	 * Retrieves all characters from the database.
	 *
	 * @return Personnage[] List of the existing characters.
	 * @throws \PDOException If something went wrong while fetching the characters.
	 */
	public function getAll(): array {
		$statement = $this->execRequest('SELECT * FROM personnages');
		$data = $statement->fetchAll(\PDO::FETCH_CLASS);
		return array_map(Personnage::fromDBObject(...), $data);
	}

	/**
	 * Retrieves a character from the database using its identifier.
	 *
	 * @param string $characterID The identifier of the character to retrieve.
	 * @return ?Personnage The character with the given identifier, or null if not found.
	 * @throws \PDOException If something went wrong while fetching the character.
	 */
	public function getByID(string $characterID): ?Personnage {
		$statement = $this->execRequest('SELECT * FROM personnages WHERE id = :id', ['id' => $characterID]);
		$data = $statement->fetchObject();
		return $data !== false ? Personnage::fromDBObject($data) : null;
	}
}
