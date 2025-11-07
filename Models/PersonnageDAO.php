<?php

namespace Models;

/**
 * DAO for manipulating {@link Personnage characters} in the database.
 */
class PersonnageDAO extends BasePDODAO {
	/**
	 * Retrieves all characters from the database.
	 *
	 * @return Personnage[] List of the existing characters
	 * @throws \PDOException If something went wrong while fetching the characters
	 */
	public function getAll(): array {
		$statement = $this->execRequest('SELECT * FROM personnages');
		$data = $statement->fetchAll(\PDO::FETCH_CLASS);
		return array_map(Personnage::fromDBObject(...), $data);
	}

	/**
	 * Retrieves a character from the database using its identifier.
	 *
	 * @param string $characterID The identifier of the character to retrieve
	 * @return ?Personnage The character with the given identifier, or null if not found
	 * @throws \PDOException If something went wrong while fetching the character
	 */
	public function getByID(string $characterID): ?Personnage {
		$statement = $this->execRequest('SELECT * FROM personnages WHERE id = :id', ['id' => $characterID]);
		$data = $statement->fetchObject();
		return $data !== false ? Personnage::fromDBObject($data) : null;
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
			'element' => $personnage->element,
			'unit_class' => $personnage->unitClass,
			'origin' => $personnage->origin,
			'rarity' => $personnage->rarity,
			'url_image' => $personnage->urlImg,
		]);
	}
}
