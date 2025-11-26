<?php

namespace Models;

/**
 * DAO for manipulating {@link User users} in the database.
 */
class UserDAO extends BasePDODAO {
	/**
	 * Retrieves a user from the database using its username.
	 *
	 * @param string $username The username of the user to retrieve
	 * @return ?User The user with the given username, or null if not found
	 * @throws \PDOException If something went wrong while fetching the user
	 */
	public function getByUsername(string $username): ?User {
		$statement = $this->execRequest('SELECT * FROM users WHERE username = :username', ['username' => $username]);
		$data = $statement->fetchObject();
		return $data !== false ? User::fromDBObject($data) : null;
	}
}
