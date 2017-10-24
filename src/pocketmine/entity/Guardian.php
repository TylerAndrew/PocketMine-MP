<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as ItemItem;

class Guardian extends WaterAnimal implements Ageable{
	const NETWORK_ID = self::GUARDIAN;

	public $width = 0.75;
	public $length = 0.75;
	public $height = 1;

	protected $exp_min = 10;
	protected $exp_max = 10;

	public function initEntity(){
		$this->setMaxHealth(30);
		parent::initEntity();
	}

	public function getName(): string{
		return "Guardian";
	}

	public function getDrops(): array{
		$drops = [ItemItem::get(ItemItem::PRISMARINE_SHARD, 0, mt_rand(0, 2))];

		if ($this->getLastDamageCause() === EntityDamageEvent::CAUSE_FIRE){
			$drops[] = ItemItem::get(ItemItem::COOKED_FISH, 0, mt_rand(0, 100) < 40 ? 1 : 0);
		} else{
			$drops[] = ItemItem::get(ItemItem::RAW_FISH, 0, mt_rand(0, 100) < 40 ? 1 : 0);
		}

		$drops[] = ItemItem::get(ItemItem::PRISMARINE_CRYSTALS, 0, mt_rand(0, 100) < 40 ? 1 : 0);

		return $drops;
	}

	public function isLeashableType(){
		return false;
	}
}
