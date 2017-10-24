<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class Shulker extends Monster{
	const NETWORK_ID = self::SHULKER;

	public $width = 1;
	public $length = 1;
	public $height = 1;

	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(30);
		parent::initEntity();
	}

	public function getName(): string{
		return "Shulker";
	}

	public function getDrops(): array{
		$drops = [
			ItemItem::get(ItemItem::SHULKER_SHELL)
		];

		return $drops;
	}
}
