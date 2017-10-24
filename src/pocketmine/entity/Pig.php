<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as ItemItem;

class Pig extends Animal implements Rideable{
	const NETWORK_ID = self::PIG;

	public $width = 0.625;
	public $height = 1;
	public $lenght = 1.5;

	protected $exp_min = 1;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(10);
		parent::initEntity();
	}

	public function getName(): string{
		return "Pig";
	}

	public function getDrops(): array{
		$drops = [];
		if ($this->getLastDamageCause() === EntityDamageEvent::CAUSE_FIRE){
			$drops[] = ItemItem::get(ItemItem::COOKED_PORKCHOP, 0, mt_rand(1, 3));
		} else{
			$drops[] = ItemItem::get(ItemItem::RAW_PORKCHOP, 0, mt_rand(1, 3));
		}
		return $drops;
	}
}
