<?php

namespace Models;

/**
 * Entity that represents a logged user in the website.
 */
class User {
	/**
	 * @var int User ID.
	 */
	public int $id {
		get => $this->id;
		set => $this->id = $value;
	}

	/**
	 * @var string User username.
	 */
	public string $username {
		get => $this->username;
		set => $this->username = $value;
	}

	/**
	 * @var string User hash password.
	 */
	public string $hashPwd {
		get => $this->hashPwd;
		set => $this->hashPwd = $value;
	}

	/**
	 * Construct a new User instance based on the result of a database query.
	 *
	 * @param \stdClass $data Database element fetch result data
	 * @return static the new User instance
	 */
	public static function fromDBObject(\stdClass $data): static {
		$origin = new static();
		$origin->id = $data->id;
		$origin->username = $data->username;
		$origin->hashPwd = $data->hash_pwd;
		return $origin;
	}
}
