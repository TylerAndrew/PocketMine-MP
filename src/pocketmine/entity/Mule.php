<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class Mule extends Horse{
	const NETWORK_ID = self::MULE;

	public $width = 0.75;
	public $height = 1.562;
	public $lenght = 1.5;//TODO

	protected $exp_min = 1;
	protected $exp_max = 3;//TODO

	public function initEntity(){
		$this->setMaxHealth(parent::getMaxHealth());
		parent::initEntity();
	}

	public function getName(): string{
		return "Mule";
	}

	public function getDrops(): array{
		$drops = [
			ItemItem::get(ItemItem::LEATHER, 0, mt_rand(0, 2))
		];

		return $drops;
	}
}
