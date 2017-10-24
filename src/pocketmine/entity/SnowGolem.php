<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class SnowGolem extends Animal{//animal?
	const NETWORK_ID = self::SNOW_GOLEM;

	public $height = 1.875;
	public $width = 1.281;
	public $lenght = 0.688;

	protected $exp_min = 0;
	protected $exp_max = 0;

	public function initEntity(){
		$this->setMaxHealth(4);
		parent::initEntity();
	}

	public function getName(): string{
		return "Snow Golem";
	}

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::SNOWBALL, 0, mt_rand(0, 15))//TODO check
		];
	}

	public function isLeashableType(){
		return false;
	}
}