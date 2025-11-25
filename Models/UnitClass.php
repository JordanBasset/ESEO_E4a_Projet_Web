<?php

namespace Models;

/**
 * Entity that represents an unit class in the game.
 */
class UnitClass {
	/**
	 * @var int Unit class ID.
	 */
	public int $id {
		get => $this->id;
		set => $this->id = $value;
	}

	/**
	 * @var string Unit class name.
	 */
	public string $name {
		get => $this->name;
		set => $this->name = $value;
	}

	/**
	 * @var string Unit class image URL.
	 */
	public string $urlImg {
		get => $this->urlImg;
		set => $this->urlImg = $value;
	}

	/**
	 * Construct a new Unit class instance based on the result of a database query.
	 *
	 * @param \stdClass $data Database element fetch result data
	 * @return static the new Unit class instance
	 */
	public static function fromDBObject(\stdClass $data): static {
		$unitClass = new static();
		$unitClass->id = $data->id;
		$unitClass->name = $data->name;
		$unitClass->urlImg = $data->url_img;
		return $unitClass;
	}
}
