<?php

namespace Models;

/**
 * DAO for manipulating {@link Personnage characters} in the database.
 */
class PersonnageDAO extends BasePDODAO {
	/**
	 * Retrieves all characters from the database.
	 *
	 * @return \stdClass[] List of the existing characters
	 * @throws \PDOException If something went wrong while fetching the characters
	 */
	public function getAll(): array {
		$statement = $this->execRequest('SELECT * FROM personnages');
		return $statement->fetchAll(\PDO::FETCH_OBJ);
	}

	/**
	 * Retrieves a character from the database using its identifier.
	 *
	 * @param string $characterID The identifier of the character to retrieve
	 * @return \stdClass|false The character with the given identifier, or null if not found
	 * @throws \PDOException If something went wrong while fetching the character
	 */
	public function getByID(string $characterID): \stdClass|false {
		$statement = $this->execRequest('SELECT * FROM personnages WHERE id = :id', ['id' => $characterID]);
		return $statement->fetchObject();
	}

	/**
	 * Creates a new character in the database.
	 *
	 * @param Personnage $personnage Character to create
	 * @throws \PDOException If something went wrong while creating the character
	 */
	public function createPersonnage(Personnage $personnage): void {
		$sql = 'INSERT INTO personnages (id, name, element, unit_class, origin, rarity, url_image) VALUES (:id, :name, :element, :unit_class, :origin, :rarity, :url_image)';
		$this->execRequest($sql, [
			'id' => $personnage->id,
			'name' => $personnage->name,
			'element' => $personnage->element->id,
			'unit_class' => $personnage->unitClass->id,
			'origin' => $personnage->origin->id,
			'rarity' => $personnage->rarity,
			'url_image' => $personnage->urlImg,
		]);
	}

	/**
	 * Removes a character from the database.
	 *
	 * @param string $id Identifier of the character to remove
	 * @throws \PDOException If something went wrong while removing the character
	 */
	public function deletePersonnage(string $id): void {
		$this->execRequest('DELETE FROM personnages WHERE id = :id', ['id' => $id]);
	}

	/**
	 * Edits an existing character in the database.
	 *
	 * @param array $personnageData Character data to update. Must contain all the characters' fields.
	 * @throws \PDOException If something went wrong while updating the character.
	 */
	public function editPersonnage(array $personnageData): void {
		$sql = 'UPDATE personnages SET name = :name, element = :element, unit_class = :unit_class, origin = :origin, rarity = :rarity, url_image = :url_image WHERE id = :id';
		$this->execRequest($sql, [
			'id' => $personnageData['id'],
			'name' => $personnageData['name'],
			'element' => $personnageData['element'],
			'unit_class' => $personnageData['unitClass'],
			'origin' => $personnageData['origin'],
			'rarity' => $personnageData['rarity'],
			'url_image' => $personnageData['urlImg'],
		]);
	}
}
