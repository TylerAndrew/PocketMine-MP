<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class PolarBear extends Monster{
	const NETWORK_ID = self::POLAR_BEAR;

	public $width = 1.031;
	public $length = 0.891;
	public $height = 2;

	protected $exp_min = 1;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(30);
		parent::initEntity();
	}

	public function getName(): string{
		return "Polar Bear";
	}

	public function getDrops(): array{
		$drops = [mt_rand(0, 3) == 0 ? ItemItem::get(ItemItem::RAW_FISH) : ItemItem::get(ItemItem::RAW_SALMON)];

		return $drops;
	}
}
