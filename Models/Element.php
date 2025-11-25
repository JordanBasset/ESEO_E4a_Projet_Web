<?php

namespace Models;

/**
 * Entity that represents an element in the game.
 */
class Element {
	/**
	 * @var int Element ID.
	 */
	public int $id {
		get => $this->id;
		set => $this->id = $value;
	}

	/**
	 * @var string Element name.
	 */
	public string $name {
		get => $this->name;
		set => $this->name = $value;
	}

	/**
	 * @var string Element image URL.
	 */
	public string $urlImg {
		get => $this->urlImg;
		set => $this->urlImg = $value;
	}

	/**
	 * Construct a new Element instance based on the result of a database query.
	 *
	 * @param \stdClass $data Database element fetch result data
	 * @return static the new Element instance
	 */
	public static function fromDBObject(\stdClass $data): static {
		$element = new static();
		$element->id = $data->id;
		$element->name = $data->name;
		$element->urlImg = $data->url_img;
		return $element;
	}
}
