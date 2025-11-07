<?php

namespace Models;

/**
 * Entity that represents a character in the game.
 */
class Personnage {
	/**
	 * @var ?string Character ID.
	 */
	public ?string $id {
		get => $this->id;
		set => $this->id = $value;
	}

	/**
	 * @var string Character name.
	 */
	public string $name {
		get => $this->name;
		set => $this->name = $value;
	}

	/**
	 * @var string Character element (Element in Genshin Impact).
	 */
	public string $element {
		get => $this->element;
		set => $this->element = $value;
	}

	/**
	 * @var string Character unit class (Weapon in Genshin Impact).
	 */
	public string $unitClass {
		get => $this->unitClass;
		set => $this->unitClass = $value;
	}

	/**
	 * @var int Character rarity (Quality in Genshin Impact).
	 */
	public int $rarity {
		get => $this->rarity;
		set => $this->rarity = $value;
	}

	/**
	 * @var ?string Character origin (Region in Genshin Impact).
	 */
	public ?string $origin {
		get => $this->origin;
		set => $this->origin = $value;
	}

	/**
	 * @var string Character image URL.
	 */
	public string $urlImg {
		get => $this->urlImg;
		set => $this->urlImg = $value;
	}

	public static function fromDBObject(\stdClass $data): static {
		$personnage = new static();
		$personnage->id = $data->id;
		$personnage->name = $data->name;
		$personnage->element = $data->element;
		$personnage->unitClass = $data->unit_class;
		$personnage->rarity = (int)$data->rarity;
		$personnage->origin = $data->origin;
		$personnage->urlImg = $data->url_image;
		return $personnage;
	}

	public static function fromRequestParams(string $id, string $name, string $element, string $unitClass, int $rarity, string $origin, string $imageUrl): static {
		$personnage = new static();
		$personnage->id = $id;
		$personnage->name = $name;
		$personnage->element = $element;
		$personnage->unitClass = $unitClass;
		$personnage->rarity = $rarity;
		$personnage->origin = $origin;
		$personnage->urlImg = $imageUrl;
		return $personnage;
	}
}
