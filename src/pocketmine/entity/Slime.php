<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\nbt\tag\IntTag;

class Slime extends Monster{
	const NETWORK_ID = self::SLIME;
	const DATA_SIZE = 16;

	public $height = 2;
	public $width = 2;
	public $lenght = 2;//TODO: Size

	protected $exp_min = 1;
	protected $exp_max = 1;//TODO: Size


	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();
		if (!isset($this->namedtag->Size)){
			$this->setSize(mt_rand(0, 3));
		}
		$this->setSize($this->getSize());
	}

	public function getName(): string{
		return "Slime";
	}

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::SLIMEBALL, 0, mt_rand(0, 2))
		];
	}

	public function setSize($value){
		$this->namedtag->Size = new IntTag("Size", $value);
		$this->setDataProperty(self::DATA_SIZE, self::DATA_TYPE_INT, $value);
	}

	public function getSize(){
		return $this->namedtag["Size"];
	}

}
