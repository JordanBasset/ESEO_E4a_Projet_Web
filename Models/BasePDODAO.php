<?php

namespace Models;

use Config\Config;

/**
 * Base class for PDO-based data access objects (DAOs).
 */
abstract class BasePDODAO {
	private ?\PDO $db = null;

	/**
	 * Executes a prepared statement with the given parameters.
	 *
	 * @param string $query The SQL query to execute
	 * @param array $params Parameters to bind to the query
	 * @return \PDOStatement The prepared statement
	 * @throws \PDOException If something went wrong while preparing/executing the query
	 */
	protected function execRequest(string $query, array $params = []): \PDOStatement {
		$stmt = $this->getDb()->prepare($query);
		if (!empty($params)) {
			$index = 1;
			foreach ($params as $key => $value) {
				$key = is_int($key) ? $index++ : ":$key";
				$stmt->bindValue($key, $value);
			}
		}
		$stmt->execute();
		return $stmt;
	}

	/**
	 * Returns or creates the database connection.
	 *
	 * @return \PDO The newly established database connection
	 * @throws \RuntimeException If the database DSN was not configured
	 * @throws \PDOException If something went wrong while connecting to the database
	 */
	private function getDb(): \PDO {
		if ($this->db === null) {
			$dsn = Config::get('dsn') ?: throw new \RuntimeException('No DSN configured');
			$user = Config::get('user', 'root');
			$pass = Config::get('pass', 'root');
			$this->db = new \PDO($dsn, $user, $pass);
			$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
		}

		return $this->db;
	}
}
