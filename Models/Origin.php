<?php

namespace Models;

/**
 * Entity that represents an origin in the game.
 */
class Origin {
	/**
	 * @var int Origin ID.
	 */
	public int $id {
		get => $this->id;
		set => $this->id = $value;
	}

	/**
	 * @var string Origin name.
	 */
	public string $name {
		get => $this->name;
		set => $this->name = $value;
	}

	/**
	 * @var string Origin image URL.
	 */
	public string $urlImg {
		get => $this->urlImg;
		set => $this->urlImg = $value;
	}

	/**
	 * Construct a new Origin instance based on the result of a database query.
	 *
	 * @param \stdClass $data Database element fetch result data
	 * @return static the new Origin instance
	 */
	public static function fromDBObject(\stdClass $data): static {
		$origin = new static();
		$origin->id = $data->id;
		$origin->name = $data->name;
		$origin->urlImg = $data->url_img;
		return $origin;
	}
}
