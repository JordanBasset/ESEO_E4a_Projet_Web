<?php

namespace Models;

/**
 * DAO for manipulating {@link Origin origins} in the database.
 */
class OriginDAO extends BasePDODAO {
	/**
	 * Retrieves all origins from the database.
	 *
	 * @return Origin[] List of the existing origins
	 * @throws \PDOException If something went wrong while fetching the origins
	 */
	public function getAll(): array {
		$statement = $this->execRequest('SELECT * FROM origins');
		$data = $statement->fetchAll(\PDO::FETCH_CLASS);
		return array_map(Origin::fromDBObject(...), $data);
	}

	/**
	 * Retrieves an origin from the database using its identifier.
	 *
	 * @param string $originID The identifier of the origin to retrieve
	 * @return ?Origin The origin with the given identifier, or null if not found
	 * @throws \PDOException If something went wrong while fetching the origin
	 */
	public function getByID(string $originID): ?Origin {
		$statement = $this->execRequest('SELECT * FROM origins WHERE id = :id', ['id' => $originID]);
		$data = $statement->fetchObject();
		return $data !== false ? Origin::fromDBObject($data) : null;
	}

	/**
	 * Creates a new origin in the database.
	 *
	 * @param Origin $origin Origin to create
	 * @throws \PDOException If something went wrong while creating the origin
	 */
	public function createOrigin(Origin $origin): void {
		$this->execRequest('INSERT INTO origins (name, url_img) VALUES (:name, :url_img)', [
			'name' => $origin->name,
			'url_img' => $origin->urlImg,
		]);
	}
}
