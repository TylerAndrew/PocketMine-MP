<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class Horse extends Animal implements Rideable, Ageable{
	const NETWORK_ID = 23;

	public $width = 0.75;
	public $height = 1.562;

	protected $exp_min = 1;
	protected $exp_max = 3;//TODO

	public function initEntity(){
		$this->setMaxHealth(10);//TODO random
		parent::initEntity();
	}

	public function getName(): string{
		return "Horse";//TODO: Name by type
	}

	public function getDrops(): array{
		$drops = [
			ItemItem::get(ItemItem::LEATHER, 0, mt_rand(0, 2))
		];

		return $drops;
	}

	public function canBeLeashed(){
		return true; //TODO: distance check, already leashed check
	}
}
