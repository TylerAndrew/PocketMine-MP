<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class IronGolem extends Animal{//is animal?
	const NETWORK_ID = self::IRON_GOLEM;

	public $height = 2.688;
	public $width = 1.625;
	public $lenght = 0.906;

	public function initEntity(){
		$this->setMaxHealth(100);
		parent::initEntity();
	}

	public function getName(): string{
		return "Iron Golem";
	}

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::IRON_INGOT, 0, mt_rand(3, 5)),
			ItemItem::get(ItemItem::POPPY, 0, mt_rand(0, 2))
		];
	}
}