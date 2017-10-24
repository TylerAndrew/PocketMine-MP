<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as ItemItem;

class Mooshroom extends Animal{
	const NETWORK_ID = self::MOOSHROOM;

	public $height = 1.875;
	public $width = 0.891;
	public $lenght = 1.781;

	protected $exp_min = 1;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(10);
		parent::initEntity();
	}

	public function getName(): string{
		return "Mooshroom";
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

	public function sheer(){
		for ($i = 0; $i <= mt_rand(0, 2); $i++){
			$this->getLevel()->dropItem($this, new ItemItem(ItemItem::RED_MUSHROOM));//TODO: check amount, remove Mooshroom and make cow
		}
	}
}