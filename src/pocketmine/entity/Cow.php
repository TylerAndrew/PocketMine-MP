<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as ItemItem;

class Cow extends Animal{
	const NETWORK_ID = self::COW;

	public $width = 0.75;
	public $height = 1.562;
	public $lenght = 1.5;

	protected $exp_min = 1;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(10);
		parent::initEntity();
	}

	public function getName(): string{
		return "Cow";
	}

	public function getDrops(): array{
		$drops = [
			ItemItem::get(ItemItem::LEATHER, 0, mt_rand(0, 2))
		];

		if ($this->getLastDamageCause() === EntityDamageEvent::CAUSE_FIRE){
			$drops[] = ItemItem::get(ItemItem::COOKED_BEEF, 0, mt_rand(1, 3));
		} else{
			$drops[] = ItemItem::get(ItemItem::RAW_BEEF, 0, mt_rand(1, 3));
		}

		return $drops;
	}
}
