<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\nbt\tag\IntTag;

class MagmaCube extends Living{
	const NETWORK_ID = self::MAGMA_CUBE;
	const DATA_SIZE = 16;

	public $width = 2;
	public $length = 2;
	public $height = 2;//TODO: Size

	protected $exp_min = 1;
	protected $exp_max = 1; //TODO: Size


	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();
		if (!isset($this->namedtag->Size)){
			$this->setSize(mt_rand(0, 3));
		}
	}

	public function getName(): string{
		return "Magma Cube";
	}

	//TODO: Stop lava/fire damage

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::MAGMA_CREAM, 0, mt_rand(0, 2))
		];
	}

	public function setSize($value){
		$this->namedtag->Size = new IntTag("Size", $value);//TODO: check if isset
		$this->setDataProperty(self::DATA_SIZE, self::DATA_TYPE_BYTE, $value);
	}

	public function getSize(){
		return $this->namedtag["Size"];
	}
}
