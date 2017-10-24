<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class WitherSkeleton extends Monster{
	const NETWORK_ID = self::WITHER_SKELETON;

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
		return "Wither Skeleton";
	}

	public function getDrops(): array{
		$drops = [];
		if ($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Player){
			$drops = [
				ItemItem::get(ItemItem::COAL, 0, mt_rand(0, 1)),
				ItemItem::get(ItemItem::BONE, 0, mt_rand(0, 2))
			];
		}

		if ($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Creeper && $this->lastDamageCause->getEntity()->isPowered()){
			$drops = [
				ItemItem::get(ItemItem::SKULL, 1, 1)
			];
		}

		return $drops;
	}
}
