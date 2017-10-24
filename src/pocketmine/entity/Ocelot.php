<?php

namespace pocketmine\entity;

use pocketmine\nbt\tag\IntTag;

class Ocelot extends Animal implements Tameable{
	const NETWORK_ID = self::OCELOT;

	const TYPE_NORMAL = 0;
	const TYPE_BLACK = 1;
	const TYPE_ORANGE = 2;
	const TYPE_SIAMESE = 3;

	public $width = 0.312;
	public $length = 2.188;
	public $height = 0.75;

	protected $exp_min = 1;
	protected $exp_max = 3;

	public static $range = 10;
	public static $speed = 0.8;
	public static $jump = 1;
	public static $mindist = 10;


	public function initEntity(){
		$this->setMaxHealth(10);
		parent::initEntity();
		if (!isset($this->namedtag->Type) || $this->getVariant() > 3){
			$this->setVariant(self::TYPE_NORMAL);
		}
		$this->setVariant($this->namedtag->Type);
	}

	public function getName(): string{
		return "Ocelot";
	}

	public function getDrops(): array{
		return [];
	}

	public function isTamed(){
		return false;
	}

	public function setVariant($value){
		$this->namedtag->Type = new IntTag("Type", $value);
		$this->setDataProperty(self::DATA_VARIANT, self::DATA_TYPE_INT, $value);
	}

	public function getVariant(){
		return $this->namedtag["Type"];
	}
}
