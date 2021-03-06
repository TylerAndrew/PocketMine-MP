<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class Stray extends Skeleton{
	const NETWORK_ID = self::STRAY;

	public $height = 2;
	public $width = 0.781;
	public $lenght = 0.875;

	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
	}

	public function getName(): string{
		return "Stray";
	}

	public function getDrops(): array{
		$drops = [
			ItemItem::get(ItemItem::ARROW, 0, mt_rand(0, 2)),
			ItemItem::get(ItemItem::BONE, 0, mt_rand(0, 2))
		];

		if ($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Player){
			if (mt_rand(0, 199) < 5){
				$drops[] = ItemItem::get(ItemItem::BOW, 0, 1);
			}
		}

		if ($this->lastDamageCause instanceof EntityExplodeEvent and $this->lastDamageCause->getEntity() instanceof Creeper && $this->lastDamageCause->getEntity()->isPowered()){
			$drops[] = ItemItem::get(ItemItem::SKULL, 0, 1);
		}

		return $drops;
	}
}
